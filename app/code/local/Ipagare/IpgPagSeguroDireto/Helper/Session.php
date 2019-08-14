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

class Ipagare_IpgPagSeguroDireto_Helper_Session extends Mage_Core_Helper_Abstract {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  public function getCurrentOrder() {
    $order = Mage::getModel('sales/order');
    $realOrderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
    if (isset($realOrderId) && $realOrderId != null) {
      return $order->loadByAttribute('increment_id', $realOrderId);
    }

    $sessionQuote = Mage::getSingleton('checkout/session')->getQuote();
    $realOrderId = $sessionQuote->getReservedOrderId();
    $order->loadByAttribute('increment_id', $realOrderId);

    return $order;
  }

}
