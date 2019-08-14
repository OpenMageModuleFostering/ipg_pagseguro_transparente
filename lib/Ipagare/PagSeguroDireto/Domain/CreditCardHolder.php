<?php

class Ipagare_PagSeguroDireto_Domain_CreditCardHolder {

  /**
   *
   * @var type string
   */
  private $name;

  /**
   *
   * @var type string
   */
  private $cpf;

  /**
   *
   * @var type date (dd/mm/yyyy)
   */
  private $birthDate;

  /**
   *
   * @var type string
   */
  private $areaCode;

  /**
   *
   * @var type string
   */
  private $phone;

  /**
   * Initializes a new instance of the Address class
   * @param array $data
   */
  public function __construct(array $data = null) {
    if (isset($data['name'])) {
      $this->name = $data['name'];
    }
    if (isset($data['cpf'])) {
      $this->cpf = $data['cpf'];
    }
    if (isset($data['birthDate'])) {
      $this->birthDate = $data['birthDate'];
    }
    if (isset($data['areaCode'])) {
      $this->areaCode = $data['areaCode'];
    }
    if (isset($data['phone'])) {
      $this->phone = $data['phone'];
    }
  }

  public function getName() {
    return $this->name;
  }

  public function getCpf() {
    return $this->cpf;
  }

  public function getBirthDate() {
    return $this->birthDate;
  }

  public function getAreaCode() {
    return $this->areaCode;
  }

  public function getPhone() {
    return $this->phone;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function setCpf($cpf) {
    $this->cpf = $cpf;
  }

  public function setBirthDate($birthDate) {
    $this->birthDate = $birthDate;
  }

  public function setAreaCode($areaCode) {
    $this->areaCode = $areaCode;
  }

  public function setPhone($phone) {
    $this->phone = $phone;
  }

}
