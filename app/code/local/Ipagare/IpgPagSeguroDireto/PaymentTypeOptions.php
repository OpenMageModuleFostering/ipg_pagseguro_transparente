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

class Ipagare_IpgPagSeguroDireto_PaymentTypeOptions {

  private $options = array();
  private $errors = array();

  public function getOptions() {
    return $this->options;
  }

  public function addOption($option) {
    $this->options[] = $option;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function addError($error) {
    if (!array_key_exists($error, $this->errors)) {
      $this->errors[$error] = Ipagare_IpgPagSeguroDireto_Config::getError($error);
    }
  }

  public function hasErrors() {
    return count($this->errors) > 0;
  }

  public function hasOptions() {
    return count($this->options) > 0;
  }

}
