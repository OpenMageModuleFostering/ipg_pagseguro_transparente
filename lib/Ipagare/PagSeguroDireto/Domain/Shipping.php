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
 * Shipping information
 */
class Ipagare_PagSeguroDireto_Domain_Shipping {

  /**
   * Shipping address
   * @see Ipagare_PagSeguroDireto_Domain_Address
   */
  private $address;

  /**
   * Shipping type. See the Ipagare_PagSeguroDireto_Domain_ShippingType class for a list of known shipping types.
   * @see Ipagare_PagSeguroDireto_Domain_ShippingType
   */
  private $type;

  /**
   * shipping cost.
   */
  private $cost;

  /**
   * Initializes a new instance of the Ipagare_PagSeguroDireto_Domain_Shipping class
   * @param array $data
   */
  public function __construct(array $data = null) {
    if ($data) {
      if (isset($data['address']) && $data['address'] instanceof Ipagare_PagSeguroDireto_Domain_Address) {
        $this->address = $data['address'];
      }
      if (isset($data['type']) && $data['type'] instanceof Ipagare_PagSeguroDireto_Domain_ShippingType) {
        $this->type = $data['type'];
      }
      if (isset($data['cost'])) {
        $this->cost = $data['cost'];
      }
    }
  }

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
   * @see Ipagare_PagSeguroDireto_Domain_Address
   */
  public function getAddress() {
    return $this->address;
  }

  /**
   * Sets the shipping type
   * @param Ipagare_PagSeguroDireto_Domain_ShippingType $type
   * @see Ipagare_PagSeguroDireto_Domain_ShippingType
   */
  public function setType(Ipagare_PagSeguroDireto_Domain_ShippingType $type) {
    $this->type = $type;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_ShippingType the shipping type
   * @see Ipagare_PagSeguroDireto_Domain_ShippingType
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param $cost float
   */
  public function setCost($cost) {
    $this->cost = $cost;
  }

  /**
   * @return float the shipping cost
   */
  public function getCost() {
    return $this->cost;
  }

}
