<?php

class Ipagare_PagSeguroDireto_Domain_PaymentResponse {

  /**
   *
   * @var array
   */
  public $dataSend;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Parser_PaymentParserData
   */
  public $paymentParserData;

  /**
   *
   * @var array
   */
  public $errors = array();

  public static function getInstance() {
    return new Ipagare_PagSeguroDireto_Domain_PaymentResponse();
  }

  public function getDataSend() {
    return $this->dataSend;
  }

  public function setDataSend($dataSend) {
    $this->dataSend = $dataSend;
  }

  public function getPaymentParserData() {
    return $this->paymentParserData;
  }

  public function setPaymentParserData(Ipagare_PagSeguroDireto_Parser_PaymentParserData $paymentParserData) {
    $this->paymentParserData = $paymentParserData;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function setErrors($errors) {
    $this->errors = $errors;
  }

  public function addFatalError($error) {
    $this->errors['99999'] = $error;
  }

  public function hasErrors() {
    return count($this->errors);
  }

  public function isSuccess() {
    if ($this->hasErrors() || is_null($this->paymentParserData)) {
      return false;
    }

    return $this->paymentParserData->isSuccess();
  }

}
