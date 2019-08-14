<?php

/**
 * Represents a page of transactions returned by the transaction search service
 */
class Ipagare_PagSeguroDireto_Domain_TransactionSearchResponse {

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_Transaction 
   */
  private $transaction;

  /**
   *
   * @var array
   */
  public $errors = array();

  public static function getInstance() {
    return new Ipagare_PagSeguroDireto_Domain_TransactionSearchResponse();
  }

  public function getErrors() {
    return $this->errors;
  }

  public function setErrors($errors) {
    $this->errors = $errors;
  }

  public function hasErrors() {
    return count($this->errors);
  }

  public function getTransaction() {
    return $this->transaction;
  }

  public function setTransaction(Ipagare_PagSeguroDireto_Domain_Transaction $transaction) {
    $this->transaction = $transaction;
  }

}
