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

class Ipagare_IpgBase_Helper_Url extends Mage_Core_Helper_Abstract {
    
    /**
     * 
     */
    const ONE_STEP_CHECKOUT = '/onestepcheckout/';
    
    const OPC_CHECKOUT = '/checkout/onepage/';
    
    /**
     * Checkout Venda Mais
     */
    
    const CHECKOUT_VM = '/idecheckoutvm/';

    /**
     * 
     */
    const TELEVENDAS = '/ipgtelevendas/pagamento/index/';

    /**
     *
     * @var type 
     */
    private static $logger;
    
    /**
     * Initialize resource model
     */
    protected function _construct() {
    }

    public function isInTelevendasPayment() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        if (strpos($currentUrl, self::TELEVENDAS)) {
            return true;
        }
        return false;
    }
    
    public function isInOscPayment() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        if (strpos($currentUrl, self::ONE_STEP_CHECKOUT)) {
            return true;
        }
        return false;
    }
    
    public function isInOpcPayment() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        if (strpos($currentUrl, self::OPC_CHECKOUT)) {
            return true;
        }
        return false;
    }
    
    public function isInCvmPayment() {
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        if (strpos($currentUrl, self::CHECKOUT_VM)) {
            return true;
        }
        return false;
    }
    
    public function printHeaders(){
        self::$logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
        $sessionCore = $_SESSION['core'];
        $visitorData = $sessionCore['visitor_data'];
        self::$logger->info("Informacoes do cliente: \n http_user_agent= {$visitorData['http_user_agent']} \n http_accept_language = {$visitorData['http_accept_language']} \n request_uri = {$visitorData['request_uri']} \n http_referer = {$visitorData['http_referer']} \n");
    }
}
