<?php

/**
 * Shipping information
 */
class Ipagare_PagSeguroDireto_Domain_Billing {

  /**
   * Shipping address
   * @see Ipagare_PagSeguroDireto_Domain_Address
   */
  private $address;

  /**
   * Sets the shipping address
   * @see Ipagare_PagSeguroDireto_Domain_Address
   * @param Ipagare_PagSeguroDireto_Domain_Address $address
   */
  public function setAddress(Ipagare_PagSeguroDireto_Domain_Address $address) {
    $this->address = $address;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Address the shipping Address
   * @see PagSeguroAddress
   */
  public function getAddress() {
    return $this->address;
  }

}
