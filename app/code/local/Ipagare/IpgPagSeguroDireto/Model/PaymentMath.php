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

class Ipagare_IpgPagSeguroDireto_Model_PaymentMath extends Mage_Core_Model_Abstract {

  private $shopPaymentModel;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->shopPaymentModel = Mage::getModel('ipgpagsegurodireto/shopPayment');
  }

  public function getDescontoAvista(Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType) {
    return $this->getParameterValue($paymentType, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::DESCONTO_AVISTA);
  }

  public function getParameterValue(Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType, $parameterName) {
    $value = null;
    $shopPayment = $this->shopPaymentModel->getShopPayment($paymentType->getValue());
    if ($shopPayment != null) {
      $value = $shopPayment->getSetting($parameterName);
    }
    return $value;
  }

}
