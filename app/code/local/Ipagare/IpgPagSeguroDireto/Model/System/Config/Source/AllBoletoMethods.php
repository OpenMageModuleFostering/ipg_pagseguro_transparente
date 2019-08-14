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

class Ipagare_IpgPagSeguroDireto_Model_System_Config_Source_AllBoletoMethods {

  public function toOptionArray() {
    return array(
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::SANTANDER_BOLETO, 'label' => 'Boleto Santander')
    );
  }

}
