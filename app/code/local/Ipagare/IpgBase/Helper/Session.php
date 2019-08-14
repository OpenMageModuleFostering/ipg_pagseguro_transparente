<?php

/**
* 
* iPAGARE para Magento
* 
* @category     Ipagare
* @packages     IpgBase
* @copyright    Copyright (c) 2012 iPAGARE (http://www.ipagare.com.br)
* @version      1.16.4
* @license      http://www.ipagare.com.br/magento/licenca
*
*/ 

class Ipagare_IpgBase_Helper_Session extends Mage_Core_Helper_Abstract {

    private $logger;

    /**
     * Initialize resource model
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    public function getCurrentOrder() {
        $session = Mage::getSingleton('checkout/session');
        $order = Mage::getModel('sales/order');

        $sessionQuote = $session->getQuote();
        $orderId = null;
        if ($orderId == null || $orderId == "") {
            $orderId = $sessionQuote->getReservedOrderId();
            $lastRealOrderId = $session->getLastRealOrderId();
            if ($lastRealOrderId != null && $lastRealOrderId != "") {
                $orderId = $lastRealOrderId;
            }
        }

        if ($orderId == null || $orderId == "") {
            $order->loadByIncrementId($session->getLastRealOrderId());
        } else {
            $order->loadByAttribute('increment_id', $orderId);
        }

        return $order;
    }

}