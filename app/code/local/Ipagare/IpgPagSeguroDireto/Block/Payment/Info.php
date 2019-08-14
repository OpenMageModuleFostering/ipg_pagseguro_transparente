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

class Ipagare_IpgPagSeguroDireto_Block_Payment_Info extends Mage_Payment_Block_Info {

  private $logger;

  protected function _construct() {
    parent::_construct();
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    if (!Mage::helper('ipgbase/url')->isInOpcPayment()) {
      $this->setTemplate('ipagare/ipgpagsegurodireto/payment/info/default.phtml');
    }
  }

  protected function _prepareSpecificInformation($transport = null) {
    if (null !== $this->_paymentSpecificInformation) {
      return $this->_paymentSpecificInformation;
    }
    $transport = parent::_prepareSpecificInformation($transport);
    $dadosPagamento = array();
    $data = array();
    $orderId = '';

    if (!Mage::helper('ipgbase/url')->isInOpcPayment()) {
      $order = $this->getOrder();
      $realOrderId = $order->getRealOrderId();
      $orderId = $this->getPayment()->getOrderId();
      if (!Mage::helper('ipgbase/stringUtils')->isEmpty($realOrderId)) {
        $dadosPagamento = $this->getDadosPagamento();
        if (Mage::helper('ipgpagsegurodireto')->notNull($dadosPagamento)) {
          foreach ($dadosPagamento as $key => $value) {
            if (!Mage::helper('ipgbase/stringUtils')->isEmpty($value['valor'])) {
              $data[$value['titulo']] = $value['valor'];
            }
          }
        } else if ($order->getData('ipagare_order_orig') == Ipagare_IpgBase_Config::ORDER_ORIG_TELEVENDAS) {
          $param1 = strtr(trim(Mage::helper('core')->encrypt($realOrderId)), '+/=', '-_~');
          $param2 = strtr(trim(Mage::helper('core')->encrypt($order->getCustomerEmail())), '+/=', '-_~');

          $urlPayment = Mage::getModel('core/store')->load($order->getStoreId())->getUrl('ipgtelevendas/index/index/', array('param1' => $param1, 'param2' => $param2));
          $linkImage = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA, false) . "ipagare/ipgtelevendas/images/pagar.png";

          $bloco = "<p><a href=\"$urlPayment\" target=\"_blank\"><img alt=\"Clique aqui para pagar\" title=\"Clique aqui para pagar\" border=\"0\" src=\"$linkImage\"></img></a></p>";
          $bloco = $bloco . "<p>Ao clicar no botão acima você será redirecionado ao ambiente seguro da loja para realizar o pagamento.</p>";
          $data['link-televendas'] = $bloco;

          $this->logger->info('Link de pagamento. Pedido ' . $realOrderId . ': ' . $urlPayment);
        }
      }
    }
    return $transport->setData(array_merge($data, $transport->getData()));
  }

  public function getDadosPagamento() {
    $order = $this->getOrder();
    $payment = $this->getPayment();
    $bandeiraPagSeguro = "<img src=\"  " . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "ipagare/ipgpagsegurodireto/images/logo_pagseguro.png \"  />";

    $meioPagamento = $payment->getMeioPagamento();
    $formaPagamento = $payment->getFormaPagamento();
    $hasCode = !Mage::helper('ipgbase/stringUtils')->isEmpty($payment->getCodeCheckout());
    if (is_null($payment->getIdIpagarePagseguroDiretoPagamento())) {
      if ($order->getData('ipagare_order_orig') == Ipagare_IpgBase_Config::ORDER_ORIG_TELEVENDAS) {
        return null;
      }
    }

    $dadosPagamento = array();

    if (!isset($meioPagamento) || empty($meioPagamento)) {
      if ($hasCode) {
        $dadosPagamento[] = array('titulo' => $bandeiraPagSeguro, 'valor' => '<br/>');
        return $dadosPagamento;
      } else {
        $dadosPagamento[] = array('titulo' => $bandeiraPagSeguro, 'valor' => '<br/>');
        // erros
        $erros = $this->getErros();
        $list = '';
        foreach ($erros as $key => $erro) {
          $e = new Ipagare_IpgPagSeguroDireto_ErrorMessages($erro['code']);

          $list .= 'Erro(' . $e->getCode() . ') - ' . $e->getMessage() . '<br />';
        }

        $dadosPagamento[] = array('titulo' => 'Motivo', 'valor' => $list);

        return $dadosPagamento;
      }
    }
    $status = new Ipagare_PagSeguroDireto_Domain_TransactionStatus($payment->getStatus());

    $paymentType = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($meioPagamento);
    $paymentMode = Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf($formaPagamento);

    $pathImage = "ipagare/ipgpagsegurodireto/bandeiras/" . $paymentType->getValue() . '/' . $paymentMode->getParcelas() . "x.gif";
    $bandeiraMeioPagamento = "<img src=\"  " . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "$pathImage \"  />";
    $dadosPagamento[] = array('titulo' => $bandeiraPagSeguro, 'valor' => $bandeiraMeioPagamento);
    $dadosPagamento[] = array('titulo' => 'Forma de pagamento', 'valor' => $paymentMode->getCompleteName());
    $dadosPagamento[] = array('titulo' => 'Total pago', 'valor' => Mage::helper('core')->currency($payment->getValorTotal(), true, false));
    if ($payment->getTransactionCode() != null) {
      $dadosPagamento[] = array('titulo' => 'Código da transação', 'valor' => str_replace('-', '', $payment->getTransactionCode()));
    }

    if ($status->isCancelada()) {
      if (!Mage::helper('ipgbase/stringUtils')->isEmpty($payment->getMensagemCancelamento())) {
        $dadosPagamento[] = array('titulo' => 'Mensagem', 'valor' => $payment->getMensagemCancelamento());
      } else {
        $dadosPagamento[] = array('titulo' => 'Mensagem', 'valor' => $status->getMessage());
      }
    } else {
      $dadosPagamento[] = array('titulo' => 'Mensagem', 'valor' => $status->getMessage());
    }

    return $dadosPagamento;
  }

  public function isUrlEmail() {
    $currentUrl = $this->helper('core/url')->getCurrentUrl();
    if (preg_match('/email/', $currentUrl)) {
      return true;
    }
    return false;
  }

  public function getPaymentType() {
    $meioPagamento = $this->getPayment()->getMeioPagamento();

    if (!isset($meioPagamento)) {
      return false;
    }

    return new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($meioPagamento);
  }

  public function hasPaymentType() {
    $payment = $this->getPayment();
    $meioPagamento = $payment->getMeioPagamento();
    if (!isset($meioPagamento)) {
      return false;
    }
    return true;
  }

  public function getPayment() {
    $orderId = $this->getOrder()->getRealOrderId();
    $payment = Mage::getModel('ipgpagsegurodireto/entity_payment');
    $payment->loadByAttribute('order_id', $orderId);

    return $payment;
  }

  public function getErros() {
    $orderId = $this->getOrder()->getRealOrderId();
    return Mage::getModel('ipgpagsegurodireto/entity_erro')->getErrorCodes($orderId);
  }

  public function getPaymentLink() {
    $payment = $this->getPayment();
    $paymentLink = $payment->getPaymentLink();

    if (!isset($paymentLink)) {
      return false;
    }

    return $paymentLink;
  }

  public function isPaymentPending() {
    $order = $this->getOrder();
    if ($order->isCanceled() || $order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING || $order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE || $order->getState() == Mage_Sales_Model_Order::STATE_CLOSED || $order->getState() == Mage_Sales_Model_Order::STATE_HOLDED) {
      return false;
    }
    return true;
  }

  protected function getOrder() {
    $order = '';
    $currentOrder = $this->getInfo()->getOrder();
    if (isset($currentOrder)) {
      return $currentOrder;
    }
    return $order;
  }

}
