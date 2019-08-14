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

class Ipagare_IpgPagSeguroDireto_NotificationController extends Mage_Core_Controller_Front_Action {

  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  public function testAction() {

    /*
      $rules = Mage::getResourceModel('salesrule/rule_collection')->load();

      foreach ($rules as $rule) {
      if ($rule->getIsActive()) {
      $rule = Mage::getModel('salesrule/rule')->load($rule->getId());
      $conditions = $rule->getConditions();
      $conditions = $rule->getConditions()->asArray();

      foreach ($conditions['conditions'] as $_conditions):
      foreach ($_conditions['conditions'] as $_condition):
      $string = explode(',', $_condition['value']);
      for ($i = 0; $i < count($string); $i++) {
      $skus[] = trim($string[$i]);
      }
      endforeach;
      endforeach;
      }
      }
     */
  }

  public function avisoAction() {
    $notificationCode = $this->getRequest()->getParam('notificationCode');
    $this->logger->info('Iniciando Campainha para Notification Code: ' . $notificationCode . '. Parametros recebidos: ' . Mage::helper('ipgpagsegurodireto')->buildParametersForLog($this->getRequest()->getParams()));
    $log = null;
    if (!isset($notificationCode) || Mage::helper('ipgbase/stringUtils')->isEmpty($notificationCode)) {
      $log = 'Codigo de notificacao nao existe ou esta nulo.';
      $this->logger->error($log);
      $this->getResponse()->setHttpResponseCode(304);
    } else {
      $credentials = Mage::getSingleton('ipgpagsegurodireto/credential')->getAccountCredentials();
      $notificationService = new Ipagare_PagSeguroDireto_Service_NotificationService();
      $transactionSearchResponse = $notificationService->checkTransaction($credentials, $notificationCode);

      if ($transactionSearchResponse->hasErrors()) {
        $this->getResponse()->setHttpResponseCode(304);
        foreach ($transactionSearchResponse->getErrors() as $error) {
          $l = 'Erro na notificacao de aviso(' . $error->getCode() . ') ' . $error->getMessage();
          $log .= $l;
          $this->logger->error($l);
        }
      } else {
        $this->processUpdates($transactionSearchResponse->getTransaction());
        $log = 'Finalizando notificacao de aviso para Pedido com Id: ' . $transactionSearchResponse->getTransaction()->getReference();
        $this->getResponse()->setHttpResponseCode(200);
        $this->logger->info($log);
      }
      echo $log;
      exit(0);
    }
  }

  private function processUpdates(Ipagare_PagSeguroDireto_Domain_Transaction $transaction) {
    if (Mage::helper('ipgbase/stringUtils')->isEmpty($transaction->getReference())) {
      $this->logger->error('Erro ao processar atualizacoes no pedido. Pedido sem referencia.');
    }
    $orderId = $transaction->getReference();
    $order = Mage::getModel('sales/order')->loadByAttribute('increment_id', $orderId);

    if ($order->getId() == null) {
      $this->logger->error('Pedido nao encontrado com Id: ' . $orderId);
    } else {
      $payment = $this->_getRequestPayment($orderId);
      $status = new Ipagare_PagSeguroDireto_Domain_TransactionStatus($transaction->getStatus()->getCode());
      // Confere se status do do pagamento foi atualizado.
      if ((!Mage::helper('ipgbase/stringUtils')->isEmpty($status->getCode()))) {
        if ($status->getCode() != $payment->getStatus()) {
          Mage::getModel('ipgpagsegurodireto/sonda')->atualizarPagamento($order, $transaction);
          $this->logger->info('Pedido [' . $orderId . '] alterado para [' . $status->getMessage() . ']');
        } else {
          $this->logger->info('Pedido [' . $orderId . '] nao sofreu alteracao de status.');
        }
        if ($transaction->getPaymentMethod()->getCode()->getValue() != $payment->getMeioPagamento()) {
          Mage::getModel('ipgpagsegurodireto/sonda')->atualizarTabelaIpagarePagSeguro($order, $transaction);
        }
        //$transaction->setHttpResponseCode(200);
      }
      if (Mage::helper('ipgbase/stringUtils')->isEmpty($payment->getOrderId())) {
        $this->logger->info('Pedido com Id ' . $orderId . ' nao foi localizado na tabela de pagamento. ');
      }
      //$transaction->setHttpResponseCode(304);
    }
    return $transaction;
  }

  public function retornoAction() {
    $params = $this->getRequest()->getParams();
    $orderId = $params['order_id'];
    $store = $this->_getCurrentStore($orderId);

    $paramsForLog = Mage::helper('ipgpagsegurodireto')->buildParametersForLog($params);
    $this->logger->info('Notificação PagSeguro Direto - Retorno: ' . $paramsForLog);

    $sondaResult = Mage::getModel('ipgpagsegurodireto/sonda')->run($orderId);
    $urlFailure = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true) . 'checkout/onepage/failure';
    $urlSuccess = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true) . 'checkout/onepage/success';

    if ($sondaResult->hasErrors()) {
      $errors = array();
      foreach ($sondaResult->getErrors() as $error) {
        $errors[] = $error->getCode() . ' - ' . $error->getMessage();
      }
      Mage::getSingleton('checkout/session')->setErrorMessage("<ul><li>" . implode("</li><li>", $errors) . "</li></ul>");
      return $this->getResponse()->setRedirect($urlFailure);
    }

    $transactionStatus = $sondaResult->getTransaction()->getStatus();
    if ($transactionStatus->isCancelada() || $transactionStatus->isDevolvida() || $transactionStatus->isEmDisputa()) {
      return $this->getResponse()->setRedirect($urlFailure);
    } else {
      Mage::helper('ipgpagsegurodireto')->clearSession();
      Mage::getSingleton('checkout/type_onepage')->getCheckout()->setLastSuccessQuoteId(true);
      return $this->getResponse()->setRedirect($urlSuccess);
    }
  }

  private function _getRequestPayment($orderId) {
    $payment = Mage::getModel('ipgpagsegurodireto/entity_payment');
    $payment->loadByAttribute('order_id', $orderId);
    return $payment;
  }

  private function _getCurrentStore($orderId) {
    $order = Mage::getModel('sales/order');
    if ($orderId == null || $orderId == "") {
      $order = Mage::helper('ipgcore/session')->getCurrentOrder();
    } else {
      $order->loadByAttribute('increment_id', $orderId);
    }
    return $order->getStore();
  }

}
