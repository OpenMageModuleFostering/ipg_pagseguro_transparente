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

class Ipagare_IpgPagSeguroDireto_Block_Payment_Transferencia extends Mage_Payment_Block_Form {

  private $parameters;

  protected function _construct() {
    parent::_construct();
  }

  public function getParameters() {
    if ($this->parameters == null) {
      $this->parameters = Mage::getSingleton('ipgbase/session')->getPaymentData();
    }
    return $this->parameters;
  }

  public function getLastOrder() {
    return Mage::helper('ipgpagsegurodireto/session')->getCurrentOrder();
  }

}
