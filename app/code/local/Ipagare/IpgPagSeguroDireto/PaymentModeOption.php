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

class Ipagare_IpgPagSeguroDireto_PaymentModeOption {

  private $paymentMode;
  private $parcelAmount;
  private $interestRate;
  private $descontoAvista;
  private $baseGrandTotal;

  /**
   *
   * @param type $paymentMode
   * @param type $parcelAmount
   * @param type $interestRate
   * @param type $descontoAvista
   * @param type $grandTotal
   */
  public function __construct($paymentMode, $parcelAmount, $interestRate, $descontoAvista, $grandTotal) {
    $this->paymentMode = $paymentMode;
    $this->parcelAmount = $parcelAmount;
    $this->interestRate = $interestRate;
    $this->descontoAvista = $descontoAvista;
    $this->baseGrandTotal = $grandTotal;
  }

  public function setPaymentMode($paymentMode) {
    $this->paymentMode = $paymentMode;
  }

  public function getPaymentMode() {
    return $this->paymentMode;
  }

  public function setParcelAmount($parcelAmount) {
    $this->parcelAmount = $parcelAmount;
  }

  public function getParcelAmount() {
    return $this->parcelAmount;
  }

  public function setInterestRate($interestRate) {
    $this->interestRate = $interestRate;
  }

  public function getInterestRate() {
    return $this->interestRate;
  }

  public function setDescontoAvista($descontoAvista) {
    $this->descontoAvista = $descontoAvista;
  }

  public function getDescontoAvista() {
    return $this->descontoAvista;
  }

  public function hasDescontaAvista() {
    if (!is_null($this->descontoAvista) && $this->descontoAvista > 0) {
      return true;
    }
    return false;
  }

  public function setBaseGrandTotal($grandTotal) {
    $this->baseGrandTotal = $grandTotal;
  }

  public function getBaseGrandTotal() {
    return $this->baseGrandTotal;
  }

  public function getTotalDesconto() {
    if ($this->hasDescontaAvista()) {
      return $this->baseGrandTotal - $this->parcelAmount;
    }
    return $this->baseGrandTotal;
  }

}
