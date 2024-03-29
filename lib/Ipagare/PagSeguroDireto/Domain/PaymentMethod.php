<?php

/*
 * ***********************************************************************
  Copyright [2011] [Ipagare_PagSeguroDireto_ Internet Ltda.]

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 * ***********************************************************************
 */

/**
 * Payment method
 *
 */
class Ipagare_PagSeguroDireto_Domain_PaymentMethod {

  /**
   * Payment method type
   */
  private $type;

  /**
   * Payment method code
   */
  private $code;

  /**
   * Initializes a new instance of the PaymentMethod class
   *
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethodType $type
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $code
   */
  public function __construct($type = null, $code = null) {
    if ($type) {
      $this->setType($type);
    }
    if ($code) {
      $this->setCode($code);
    }
  }

  /**
   * @return the payment method type
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Sets the payment method type
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethodType $type
   */
  public function setType($type) {
    if ($type instanceof Ipagare_PagSeguroDireto_Domain_PaymentMethodType) {
      $this->type = $type;
    } else {
      $this->type = new Ipagare_PagSeguroDireto_Domain_PaymentMethodType($type);
    }
  }

  /**
   * @return the code
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Sets the payment method code
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $code
   */
  public function setCode($code) {
    if ($code instanceof Ipagare_PagSeguroDireto_Domain_PaymentMethodCode) {
      $this->code = $code;
    } else {
      $this->code = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($code);
    }
  }

}
