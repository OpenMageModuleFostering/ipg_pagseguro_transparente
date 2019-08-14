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

class Ipagare_IpgBase_Helper_OneStepCheckout extends Mage_Core_Helper_Abstract {

    private $logger;

    /**
     * Initialize resource model
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    public function getVersion() {
        $version = $this->getCompleteVersion();
        if (!Mage::helper('ipgbase/stringUtils')->isEmpty($version)) {
            return substr($version, 0, 1);
        }
        return '';
    }

    public function getCompleteVersion() {
        $resource = Mage::getSingleton('core/resource');
        $conn = $resource->getConnection('core_read');
        $sql = "SELECT version FROM {$resource->getTableName('core_resource')} WHERE code='onestepcheckout_setup'";
        $version = $conn->fetchAll($sql);
        if (!Mage::helper('ipgbase/stringUtils')->isEmpty($version[0]['version'])) {
            return $version[0]['version'];
        }
        return null;
    }

    public function isActive() {
        return Mage::getStoreConfig('onestepcheckout/general/rewrite_checkout_links');
    }

}

?>
