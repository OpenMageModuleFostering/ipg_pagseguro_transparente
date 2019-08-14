<?php

/**
* 
* iPAGARE PagSeguro para Magento
* 
* @category     Ipagare
* @packages     IpgPagSeguroDireto
* @copyright    Copyright (c) 2014 iPAGARE (http://www.ipagare.com.br)
* @version      1.1.3
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

class Ipagare_IpgPagSeguroDireto_Model_Notification extends Mage_Core_Model_Abstract {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  public function sendEmail(Mage_Sales_Model_Order $order) {
    if (!Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_ENABLED)) {
      $this->logger->info('Envio de e-mail desativado.');
      return;
    }

    try {
      if (!Mage::helper('ipgbase')->canSendEmail($order)) {
        return;
      }

      if ($order->getState() == Mage_Sales_Model_Order::STATE_NEW) {
        if (!$order->getData('ipagare_order_orig') == Ipagare_IpgBase_Config::ORDER_ORIG_TELEVENDAS) {
          $order->sendNewOrderEmail();
        }
      }

      if ($order->getState() == Mage_Sales_Model_Order::STATE_CANCELED) {
        $msgEmailConfig = Mage::getStoreConfig('ipgbase/controle_envio_email/texto_email_cancelado');
        $nomeLoja = '{{var store.getFrontendName()}}';
        $urlLoja = Mage::helper('core/url')->getHomeUrl();

        $searchUrlMsg = '##URL_LOJA##';
        $replaceUrlMsg = "<a href='$urlLoja'>$nomeLoja</a>";

        $msgEmailFinal = str_replace($searchUrlMsg, $replaceUrlMsg, $msgEmailConfig);

        $order->sendOrderUpdateEmail(true, $msgEmailFinal);
      }

      if ($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING) {
        if ($order->hasInvoices()) {
          $this->sendInvoiceEmail($order);
        } else {
          if ($order->getEmailSent()) {
            $msgEmailConfig = Mage::getStoreConfig('ipgbase/controle_envio_email/texto_email_confirmado');
            $order->sendOrderUpdateEmail(true, $msgEmailConfig);
          } else {
            $order->sendNewOrderEmail();
          }
        }
      }
    } catch (Exception $e) {
      $message = "Não foi possivel enviar email de confirmação para o pedido: " . $order->getRealOrderId();
      $this->addStatusHistoryComment($order, $message);
      $this->logger->error($message . "\n" . $e->__toString());
      return;
    }
    // FIXME: Testar Todas as formas de erro que podem ocorrer.
    $message = "Email de confirmação para o pedido " . $order->getRealOrderId() . " enviado com sucesso.";
    $this->addStatusHistoryComment($order, $message, true);
    $this->logger->info($message);

    return true;
  }

  public function sendInvoiceEmail(Mage_Sales_Model_Order $order) {
    $invoice = $this->_getOrderInvoice($order);
    if ($invoice == null) {
      return;
    }
    try {
      if (Mage::helper('ipgbase')->canSendEmail($order)) {
        $invoice->setEmailSent(true);
        $invoice->save();
        $invoice->sendEmail();
      }
    } catch (Exception $e) {
      $message = "Não foi possivel enviar email de fatura para o pedido: " . $order->getRealOrderId();
      $this->logger->error($message . "\n" . $e->__toString());
      return;
    }
    $message = "Email de fatura para o pedido " . $order->getRealOrderId() . " enviado com sucesso.";
    $this->addStatusHistoryComment($order, $message, true);
    $this->logger->info($message);
  }

  public function addStatusHistoryComment($order, $message, $notified = false) {
    $order->addStatusHistoryComment($message, false)->setIsCustomerNotified($notified);
    $order->save();
  }

  public function processCancel($orderId, $message, $sendEmail = true) {
    if (isset($orderId)) {
      $this->_processCancel($orderId, $message, $sendEmail);
    }
    return true;
  }

  protected function _processCancel($orderId, $message, $sendEmail) {
    $order = $this->_getRequestOrder($orderId);

    try {
      if ($order->getState() == Mage_Sales_Model_Order::STATE_CANCELED) {
        return true;
      }
      $order->cancel();

      //$order->addStatusToHistory($order->getStatus(), $message);
      $this->addStatusHistoryComment($order, $message);

      if ($order->hasInvoices() != '') {
        $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, Mage::helper('ipgpagsegurodireto')->__('O pagamento e o pedido foram cancelados, mas não foi possível retornar os produtos ao estoque pois já havia uma fatura gerada para este pedido.'), $notified = false);
      }
      $order->save();
      if ($sendEmail) {
        $this->sendEmail($order);
      }
      return true;
    } catch (Exception $e) {
      $this->logger->error("Erro ao cancelar pedido $orderId \n $e->__toString()");
    }

    $this->_errorViolationSequenceStates($order);

    return false;
  }

  public function processSuccess($orderId, $valorPago, $message) {
    if (isset($orderId)) {
      $this->_processSuccess($orderId, $valorPago, $message);
    }
    return true;
  }

  protected function _processSuccess($orderId, $valorPago, $message) {
    $order = $this->_getRequestOrder($orderId);
    $store = $order->getStore();
    $invoiceConfig = false;
    if ($order->getState() != Mage_Sales_Model_Order::STATE_PROCESSING) {
      $order->setState(
          Mage_Sales_Model_Order::STATE_PROCESSING, true, $message, $notified = false
      );

      $msg = "";
      $invoiceConfig = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::INVOICE, $store);
      if ($invoiceConfig) {
        if (!$invoice = $this->_getOrderInvoice($order)) {
          $invoice = $order->prepareInvoice();
          //$invoice->register()->capture();
          $invoice->register()->pay();
          $invoice->addComment(Mage::helper('ipgpagsegurodireto')->__('O pagamento do pedido foi confirmado e a nota-fiscal foi gerada automaticamente.'));
          $invoice->setTransactionId($orderId);

          $transactionSave = Mage::getModel('core/resource_transaction')
              ->addObject($invoice)
              ->addObject($invoice->getOrder())
              ->save();
        }
      }
      if (isset($valorPago) && !empty($valorPago)) {
        $order->setBaseTotalPaid($valorPago);
        $order->setTotalPaid(Mage::app()->getStore()->convertPrice($valorPago));
      }
      $order->save();
      if ($invoiceConfig) {
        if (Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::CONTROLE_ENVIO_EMAIL_FATURA_GERADA)) {
          $this->sendInvoiceEmail($order);
        }
      } else {
        $this->sendEmail($order);
      }

      return true;
    }
    return false;
  }

  /**
   * @return Mage_Sales_Model_Order
   */
  private function _getRequestOrder($codigoPedido) {
    $tam = strlen($codigoPedido);
    if ($tam > 0) {
      $order = Mage::getModel('sales/order')->loadByAttribute('increment_id', $codigoPedido);

      if ($order->isEmpty()) {
        $this->_error(Mage::helper('ipgpagsegurodireto')->__('Erro na confirmação: pedido não encontrado.'));
      }

      return $order;
    }
    return null;
  }

  /**
   * @param Mage_Sales_Model_Order $order
   */
  protected function _errorViolationSequenceStates($order) {
    $this->_error(Mage::helper('ipgpagsegurodireto')->__('Erro na confirmação do Pagamento: erro no fluxo dos status de pedido.'));
  }

  /**
   * Processa erros genÃ©ricos.
   *
   * @param string $comment
   * @param array $request
   * @param Mage_Sales_Model_Order $order
   */
  protected function _error($comment, $order = null) {
    $message = $comment . Mage::helper('ipgpagsegurodireto')->__('<br/>ParÃ¢metros da requisiÃ§Ã£o');

    if (!is_null($order)) {
      $order->addStatusToHistory($order->getStatus(), $message)->save();
    }
    Mage::throwException($comment);
  }

  protected function _getOrderInvoice($order) {
    foreach ($order->getInvoiceCollection() as $orderInvoice) {
      if ($orderInvoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_PAID ||
          $orderInvoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
        return $orderInvoice;
      }
    }
    return false;
  }

}
