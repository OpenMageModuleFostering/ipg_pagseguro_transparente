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

class Ipagare_IpgPagSeguroDireto_Helper_Validator extends Mage_Core_Helper_Abstract {

    private $logger;

    /**
     * Initialize resource model
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    /** Formata o telefone; opcional: bool para validador
     * 
     * @param type $telephone
     * @param type $returnbool
     * @return type
     */
    public function formatTelephone($telephone) {
        $formatTelephone = preg_replace("/[^0-9]/", "", $telephone);
        $formatTelephone = ltrim($formatTelephone, '0');
        if (strlen($formatTelephone) <= 11 && strlen($formatTelephone) >= 10) {
            return $formatTelephone;
        }
        return false;
    }

}