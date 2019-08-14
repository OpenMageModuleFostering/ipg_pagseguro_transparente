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

class Ipagare_IpgBase_Model_EmailService extends Mage_Core_Model_Abstract {

    private $logger;
    
    const IPG_BOLETO_POR_VENCER = 'IpgBoletoPorVencer';

    /**
     * Initialize resource model
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    public function getIdTemplateEmail() {

        $resource = Mage::getSingleton('core/resource');

        $sql = "SELECT template_id FROM {$resource->getTableName('core_email_template')} WHERE
        template_code = " . "'". self::IPG_BOLETO_POR_VENCER ."'";
        
        $readConnection = $resource->getConnection('core_read');
        $idTemplate = $readConnection->fetchOne($sql);

        return $idTemplate;
    }

}