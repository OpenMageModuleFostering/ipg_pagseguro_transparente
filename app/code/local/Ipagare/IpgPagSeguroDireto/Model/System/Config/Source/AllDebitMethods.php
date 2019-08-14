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

class Ipagare_IpgPagSeguroDireto_Model_System_Config_Source_AllDebitMethods {

  public function toOptionArray() {
    return array(
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::BRADESCO_ONLINE_TRANSFER, 'label' => 'Bradesco'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::ITAU_ONLINE_TRANSFER, 'label' => 'Itaú'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::BANCO_BRASIL_ONLINE_TRANSFER, 'label' => 'Banco do Brasil'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::BANRISUL_ONLINE_TRANSFER, 'label' => 'Banrisul'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::HSBC_ONLINE_TRANSFER, 'label' => 'HSBC')
    );
  }

}
