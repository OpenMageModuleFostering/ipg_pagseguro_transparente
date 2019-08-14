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

class Ipagare_IpgPagSeguroDireto_Model_Observer extends Mage_Core_Model_Abstract {

  private $logger;
  protected $_code = 'ipgpagsegurodireto';

  /**
   * Initialize resource model
   */
  protected function _construct() {
    parent::_construct();
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * Envia e-mail com confirmação de criação de novo pedido.
   *
   * @param Varien_Object $observer
   */
  public function sendNewOrderEmail($observer) {
    $order = $observer->getEvent()->getOrder();
    $mensagem = $observer->getEvent()->getMensagem();
    $this->logger->info('Enviando e-mail de novo pedido [' . $order->getRealOrderId() . ']');

    if ($order->getState() == Mage_Sales_Model_Order::STATE_NEW) {
      $pagamento = Mage::getModel('ipgpagsegurodireto/entity_payment')->loadByAttribute('order_id', $order->getRealOrderId());
      if ($pagamento != null && $pagamento->getOrderId()) {
        Mage::getModel('ipgpagsegurodireto/notification')->sendEmail($order);
      }
    }
    if (!Mage::helper('ipgbase/stringUtils')->isEmpty($mensagem)) {
      Mage::getModel('ipgpagsegurodireto/notification')->addStatusHistoryComment($order, $mensagem);
    }
  }

  /**
   * Confirma o pagamento e Envia e-mail com confirmação de pagamento.
   *
   * @param Varien_Object $observer
   */
  public function proccessSuccess($observer) {
    $order = $observer->getEvent()->getOrder();
    $valor = $observer->getEvent()->getValor();
    $mensagem = $observer->getEvent()->getMensagem();

    $this->logger->info('Processando confirmação de pagamento. Pedido ' . $order->getRealOrderId());

    Mage::getModel('ipgpagsegurodireto/notification')->processSuccess($order->getRealOrderId(), $valor, $mensagem);

    $this->logger->info('Confirmação de pagamento foi concluido . Pedido ' . $order->getRealOrderId());
  }

  /**
   * Cancela o pedido e Envia e-mail com confirmação de cancerlamento.
   *
   * @param Varien_Object $observer
   */
  public function proccessCancel($observer) {
    $order = $observer->getEvent()->getOrder();
    $mensagem = $observer->getEvent()->getMensagem();

    $this->logger->info('Processando cancelamento da transação ' . $order->getRealOrderId());
    Mage::getModel('ipgpagsegurodireto/notification')->processCancel($order->getRealOrderId(), $mensagem, Mage::helper('ipgbase')->canSendEmail($order));
    $this->logger->info('Cancelamento da transação foi concluida ' . $order->getRealOrderId());
  }

  public function paymentSonda() {
    $this->logger->info('Executando sonda - início');

    $listOrderIds = Mage::getModel('ipgpagsegurodireto/sonda')->getOrderIds();

    foreach ($listOrderIds as $key => $orderIds) {
      foreach ($orderIds as $k => $orderId) {
        if ($orderId != null) {
          $this->logger->info('Vai consultar pedido [' . $orderId . '] no PagSeguro.');
          Mage::getModel('ipgpagsegurodireto/sonda')->run($orderId);
        }
      }
    }
    $this->logger->info('Executando sonda - fim');
  }

}
