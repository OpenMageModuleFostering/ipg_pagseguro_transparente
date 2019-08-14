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

class Ipagare_IpgPagSeguroDireto_Model_System_Config_Source_AllCardMethods {

  public function toOptionArray() {
    return array(
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::VISA_CREDIT_CARD, 'label' => 'Visa'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::MASTERCARD_CREDIT_CARD, 'label' => 'MasterCard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::AMEX_CREDIT_CARD, 'label' => 'American Express'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::DINERS_CREDIT_CARD, 'label' => 'Diners'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::HIPERCARD_CREDIT_CARD, 'label' => 'Hipercard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::AURA_CREDIT_CARD, 'label' => 'Aura'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::ELO_CREDIT_CARD, 'label' => 'Elo'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::PLENOCARD, 'label' => 'PlenoCard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::PERSONALCARD, 'label' => 'PersonalCard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::JCB_CREDIT_CARD, 'label' => 'JCB'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::DISCOVER_CREDIT_CARD, 'label' => 'Discover'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::BRASILCARD, 'label' => 'BrasilCard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::FORTBRASIL_CREDIT_CARD, 'label' => 'FortBrasil'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::CARDBAN_CARD, 'label' => 'Cardban'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::VALECARD_CARD, 'label' => 'ValeCard'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::CABAL_CARD, 'label' => 'Cabal'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::MAIS_CARD, 'label' => 'Mais!'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::AVISTA_CARD, 'label' => 'Avista'),
        array('value' => Ipagare_PagSeguroDireto_Domain_PaymentMethodCode::GRANDCARD_CARD, 'label' => 'GrandCard')
    );
  }

}
