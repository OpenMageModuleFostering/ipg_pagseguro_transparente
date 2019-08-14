<?php

/**
 * Represents a phone number
 */
class Ipagare_PagSeguroDireto_Domain_Session {

  /**
   * ID
   */
  private $id;

  /**
   * Initializes a new instance of the Ipagare_PagSeguroDireto_Domain_Session class
   *
   * @param String $areaCode
   * @param String $number
   * @return Ipagare_PagSeguroDireto_Domain_Phone
   */
  public function __construct($id = null) {
    $this->id = ($id == null ? null : $id);
    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

}
