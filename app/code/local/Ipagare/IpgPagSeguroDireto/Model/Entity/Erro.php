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

class Ipagare_IpgPagSeguroDireto_Model_Entity_Erro extends Mage_Core_Model_Abstract {

  public function _construct() {
    $this->_init('ipgpagsegurodireto/entity_erro');
  }

  public function loadByAttribute($attribute, $value) {
    $this->load($value, $attribute);
    return $this;
  }

  public function getErrorCodes($orderId) {
    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $sql = "SELECT `code` FROM `{$resource->getTableName('ipagare_pagsegurodireto_erro')}` WHERE `order_id` = {$orderId} ";
    return $readConnection->fetchAll($sql);
  }

}
