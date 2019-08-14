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
 * Defines a list of known transaction statuses.
 * This class is not an enum to enable the introduction of new shipping types
 * without breaking this version of the library.
 */
class Ipagare_PagSeguroDireto_Domain_TransactionStatus {

  /**
   * @var array
   */
  private static $statusList = array(
      '1' => array('code' => 1, 
                   'module' => 'WAITING_PAYMENT', 
                   'client' => 'Aguardando pagamento',
                   'message' => 'O comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.'),
      '2' => array('code' => 2, 
                   'module' => 'IN_ANALYSIS', 
                   'client' => 'Em análise',
                   'message' => 'O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.'),
      '3' => array('code' => 3, 
                   'module' => 'PAID', 
                   'client' => 'Paga',
                   'message' => 'A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.'),
      '4' => array('code' => 4, 
                   'module' => 'AVAILABLE', 
                   'client' => 'Disponível',
                   'message' => 'A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.'),
      '5' => array('code' => 5, 
                   'module' => 'IN_DISPUTE', 
                   'client' => 'Em disputa',
                   'message' => 'O comprador, dentro do prazo de liberação da transação, abriu uma disputa.'),
      '6' => array('code' => 6, 
                   'module' => 'REFUNDED', 
                   'client' => 'Devolvida',
                   'message' => 'O valor da transação foi devolvido para o comprador.'),
      '7' => array('code' => 7, 
                   'module' => 'CANCELED', 
                   'client' => 'Cancelada',
                   'message' => 'A transação foi cancelada sem ter sido finalizada.'));

  /**
   *
   * @var type
   */
  private $code;

  /**
   *
   * @var type
   */
  private $module;
  private $message;
  private $clientMessage;

  /**
   * @param null $code
   */
  public function __construct($code = null) {
    if ($code) {
      $this->code = $code;
      $a = self::$statusList[$code];
      $this->module = $a['module'];
      $this->message = $a['message'];
      $this->clientMessage = $a['client'];
    }
  }

  /**
   * @param $code
   */
  public function setCode($code) {
    $this->code = $code;
  }

  /**
   * @return integer the status value.
   */
  public function getCode() {
    return $this->code;
  }

  public function getTypeFromCode($code = null) {
    $code = ($code == null ? $this->code : $code);
    return array_search($this->code, self::$statusList);
  }

  /**
   * Get status list
   * @return array
   */
  public static function getStatusList() {
    return self::$statusList;
  }

  public function getModule() {
    return $this->module;
  }

  public function setModule($module) {
    $this->module = $module;
  }

  public function isAguardandoPagamento() {
    return (bool) ($this->code == '1');
  }

  public function isEmAnalise() {
    return (bool) ($this->code == '2');
  }

  public function isPaga() {
    return (bool) ($this->code == '3');
  }

  public function isDisponivel() {
    return (bool) ($this->code == '4');
  }

  public function isEmDisputa() {
    return (bool) ($this->code == '5');
  }

  public function isDevolvida() {
    return (bool) ($this->code == '6');
  }

  public function isCancelada() {
    return (bool) ($this->code == '7');
  }

  public function getMessage() {
    return $this->message;
  }

  public function setMessage($message) {
    $this->message = $message;
  }

  public function getClientMessage() {
    return $this->clientMessage;
  }

  public function setClientMessage($clientMessage) {
    $this->clientMessage = $clientMessage;
  }
}
