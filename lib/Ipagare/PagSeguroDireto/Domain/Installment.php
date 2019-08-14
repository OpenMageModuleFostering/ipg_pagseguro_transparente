<?php

/**
 * Represents the party on the transaction that is sending the money
 */
class Ipagare_PagSeguroDireto_Domain_Installment {

  /**
   *
   * @var type 
   */
  private $quantity;

  /**
   *
   * @var type 
   */
  private $value;

  /**
   * Initializes a new instance of the Sender class
   *
   * @param array $data
   */
  public function __construct(array $data = null) {
    if ($data) {
      if (isset($data['quantity'])) {
        $this->quantity = $data['quantity'];
      }
      if (isset($data['value'])) {
        $this->value = $data['value'];
      }
    }
  }

  public function getQuantity() {
    return $this->quantity;
  }

  public function getValue() {
    return $this->value;
  }

  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }

  public function setValue($value) {
    $this->value = $value;
  }

}
