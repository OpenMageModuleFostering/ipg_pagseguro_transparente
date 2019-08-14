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
 * Defines a list of known payment method types.
 */
class Ipagare_PagSeguroDireto_Domain_PaymentMethodType {

  private static $typeList = array(
      '1' => array('code' => 1, 'module' => 'creditCard', 'label' => 'Cartão de Crédito'),
      '2' => array('code' => 2, 'module' => 'boleto', 'label' => 'Boleto Bancário'),
      '3' => array('code' => 3, 'module' => 'etf', 'label' => 'Transferência On-line')
  );
  private $code;
  private $module;
  private $label;

  /**
   * @param null $code
   */
  public function __construct($code = null) {
    if ($code) {
      $this->code = $code;
      $a = self::$typeList[$code];
      $this->module = $a['module'];
      $this->label = $a['label'];
    }
  }

  public function setCode($code) {
    $this->code = $code;
  }

  public function setByType($type) {
    if (isset(self::$typeList[$type])) {
      $this->code = self::$typeList[$type];
    } else {
      throw new Exception("undefined index $type");
    }
  }

  /**
   * @return integer payment method type value
   * Example: 1
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * @param value
   * @return Ipagare_PagSeguroDireto_Domain_PaymentMethodType the corresponding to the informed value
   */
  public function getTypeFromCode($code = null) {
    $code = ($code == null ? $this->code : $code);
    return array_search($this->code, self::$typeList);
  }

  public static function getTypeList() {
    return self::$typeList;
  }

  public function getModule() {
    return $this->module;
  }

  public function getLabel() {
    return $this->label;
  }

  public static function setTypeList($typeList) {
    self::$typeList = $typeList;
  }

  public function setModule($module) {
    $this->module = $module;
  }

  public function setLabel($label) {
    $this->label = $label;
  }

}
