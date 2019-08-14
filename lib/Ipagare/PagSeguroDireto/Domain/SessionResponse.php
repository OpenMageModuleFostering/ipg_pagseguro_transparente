<?php

class Ipagare_PagSeguroDireto_Domain_SessionResponse {

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_Session
   */
  private $session;

  /**
   *
   * @var array
   */
  public $errors = array();

  public static function getInstance() {
    return new Ipagare_PagSeguroDireto_Domain_SessionResponse();
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
    if ($this->hasErrors() || is_null($this->session)) {
      return false;
    }

    return true;
  }

  public function getSession() {
    return $this->session;
  }

  public function setSession(Ipagare_PagSeguroDireto_Domain_Session $session) {
    $this->session = $session;
  }

}
