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

class Ipagare_IpgPagSeguroDireto_PaymentTypeOption {

  private $paymentType;
  private $paymentModeOptions = array();
  private $maskedCreditCard;

  public function getPaymentModeOptions() {
    return $this->paymentModeOptions;
  }

  public function setPaymentModes($paymentModeOptions) {
    $this->paymentModeOptions = $paymentModeOptions;
  }

  public function getPaymentType() {
    return $this->paymentType;
  }

  public function setPaymentType($paymentType) {
    $this->paymentType = $paymentType;
  }

  public function getMaskedCreditCard() {
    return $this->maskedCreditCard;
  }

  public function setMaskedCreditCard($maskedCreditCard) {
    $this->maskedCreditCard = $maskedCreditCard;
  }

  public function getMaxPaymentMode() {
    $indice = count($this->paymentModeOptions) - 1;
    return $this->paymentModeOptions[$indice];
  }

}
