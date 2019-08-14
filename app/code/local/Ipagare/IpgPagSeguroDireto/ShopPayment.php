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

class Ipagare_IpgPagSeguroDireto_ShopPayment {

  private $settings = array();

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_PaymentMethodCode
   */
  private $paymentType;

  /**
   *
   * @param type $key
   * @return type
   */
  public function getSetting($key) {
    if (array_key_exists($key, $this->settings)) {
      return $this->settings[$key];
    }
  }

  /**
   *
   * @param type $key
   * @param type $value
   */
  public function addSetting($key, $value) {
    if (!array_key_exists($key, $this->settings)) {
      $this->settings[$key] = $value;
    }
  }

  public function setPaymentType($paymentType) {
    $this->paymentType = $paymentType;
  }

  public function getPaymentType() {
    return $this->paymentType;
  }

}
