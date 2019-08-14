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

Mage::helper('ipgpagsegurodireto')->getPagSeguroLibrary();

class Ipagare_IpgPagSeguroDireto_PaymentController extends Mage_Core_Controller_Front_Action {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    /**
     * Não remover esse log. 
     */
    Mage::log('Iniciando pagamento');
  }

  public function payAction() {
    $order = Mage::helper('ipgbase/session')->getCurrentOrder();
    $store = $order->getStore();
    $urlLojaSucesso = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true) . 'checkout/onepage/success';
    $urlLojaFalha = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true) . 'checkout/onepage/failure';
    $urlLojaTransferencia = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true) . 'ipgpagsegurodireto/payment/transferencia/order_id/' . $order->getRealOrderId();

    $sessionCoreMage = Mage::getSingleton('ipgbase/session');

    $paymentType = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($sessionCoreMage->getMeioPagamento());
    $paymentMode = Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf($sessionCoreMage->getFormaPagamento());

    $this->logger->info('Início pagamento do pedido ' . $order->getIncrementId());
    Mage::helper('ipgbase/url')->printHeaders();

    /**
     * Já tem pagamento
     */
    $paymentModel = Mage::getModel('ipgpagsegurodireto/payment');
    if ($paymentModel->hasPayment($order->getIncrementId())) {
      $this->logger->info('Já consta um pagamento para o pedido ' . $order->getIncrementId());

      Mage::helper('ipgpagsegurodireto')->clearSession();
      Mage::getSingleton('checkout/type_onepage')->getCheckout()->setLastSuccessQuoteId(true);

      return $this->getResponse()->setRedirect($urlLojaSucesso);
    }

    $paymentResponse = $paymentModel->pay($order, $paymentType);

    /**
     * Erros
     */
    if ($paymentResponse->hasErrors()) {
      $errors = array();
      foreach ($paymentResponse->getErrors() as $error) {
        $errors[] = $error->getCode() . ' - ' . $error->getMessage();

        Mage::getSingleton('ipgpagsegurodireto/payment')->saveError($error->getCode(), $order->getRealOrderId());
      }
      Mage::getSingleton('checkout/session')->setErrorMessage("<ul><li>" . implode("</li><li>", $errors) . "</li></ul>");

      Mage::getSingleton('ipgbase/session')->clear();

      /**
       * Verifica se cancela pedido
       */
      $cancelOrderConfig = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CANCEL_ORDER, $store);
      if ($cancelOrderConfig) {
        $this->logger->info('Cancelando pedido ' . $order->getIncrementId() . ' por falha no pagamento.');
        Mage::getModel('ipgbase/expiraPedido')->cancelaPedido($order);
      }

      return $this->getResponse()->setRedirect($urlLojaFalha);
    }

    /**
     * Sucesso
     */
    //if ($paymentResponse->isSuccess()) {
    $paymentParserData = $paymentResponse->getPaymentParserData();
    $paymentType = $paymentParserData->getPaymentMethod()->getCode();
    $transactionStatus = $paymentParserData->getStatus();

    Mage::getSingleton('ipgbase/session')->setPaymentData($paymentParserData);

    /**
     * Salva os dados de pagamento
     */
    Mage::getSingleton('ipgpagsegurodireto/payment')->save($paymentParserData, $paymentMode);

    /**
     * Cria a sonda
     */
    if (!$transactionStatus->isCancelada()) {
      Mage::getModel('ipgpagsegurodireto/sonda')->criarSonda($order->getRealOrderId());

      $order->getPayment()->setAdditionalInformation('ipgpagsegurodireto_use_status_sonda', '1')->save();
    }

    if ($transactionStatus->isPaga() || $transactionStatus->isDisponivel() || $transactionStatus->isDevolvida()) {
      Mage::getModel('ipgpagsegurodireto/sonda')->removerSonda($order->getRealOrderId());
      // captura pagamento, passa pedido para proccessing e envia e-mail de pagamento em caso de sucesso
      Mage::dispatchEvent('ipgpagsegurodireto_proccess_success', array('order' => $order, 'valor' => $paymentParserData->getGrossAmount(), 'mensagem' => $transactionStatus->getMessage()));
    } else {
      // envia e-mail de pedido criado para status de transação em andamento
      Mage::dispatchEvent('ipgpagsegurodireto_send_new_order_email', array('order' => $order, 'mensagem' => $transactionStatus->getMessage()));
    }

    Mage::helper('ipgpagsegurodireto')->clearSession();
    $this->logger->info('Finalizando transação com sucesso do pedido ' . $order->getIncrementId());
    Mage::getSingleton('checkout/type_onepage')->getCheckout()->setLastSuccessQuoteId(true);

    if ($paymentType->isCreditCard() || $paymentType->isBoleto()) {
      return $this->getResponse()->setRedirect($urlLojaSucesso);
    } else if ($paymentType->isDebitoBancario()) {
      return $this->getResponse()->setRedirect($urlLojaTransferencia);
    }
  }

  public function transferenciaAction() {
    $this->loadLayout();
    $this->_initLayoutMessages('core/session');
    $this->renderLayout();
  }

}
