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
 * Class Ipagare_PagSeguroDireto_Parser_PaymentParserData
 */
class Ipagare_PagSeguroDireto_Parser_PaymentParserData {

  /**
   *
   * @var string
   */
  public $date;

  /**
   *
   * @var string
   */
  public $lastEventDate;

  /**
   *
   * @var string
   */
  public $code;

  /**
   *
   * @var string
   */
  private $reference;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_TransactionType
   */
  private $type;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_TransactionStatus
   */
  private $status;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_TransactionCancellationSource
   */
  private $cancellationSource;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_PaymentMethod
   */
  private $paymentMethod;

  /**
   *
   * @var string
   */
  private $paymentLink;

  /**
   *
   * @var float
   */
  private $grossAmount;

  /**
   *
   * @var float
   */
  private $discountAmount;

  /**
   *
   * @var float
   */
  private $feeAmount;

  /**
   *
   * @var float
   */
  private $netAmount;

  /**
   *
   * @var float
   */
  private $extraAmount;

  /**
   *
   * @var string
   */
  private $escrowEndDate;

  /**
   *
   * @var int
   */
  private $installmentCount;

  /**
   *
   * @var string
   */
  private $xmlReturn;

  /**
   * 
   * @param array $data
   */
  public static function getInstance($data) {
    $payment = new Ipagare_PagSeguroDireto_Parser_PaymentParserData();
    $payment->setDate($data['date']);
    $payment->setLastEventDate($data['lastEventDate']);
    $payment->setCode($data['code']);
    $payment->setReference($data['reference']);
    $payment->setType(new Ipagare_PagSeguroDireto_Domain_TransactionType($data['type']));
    $payment->setStatus(new Ipagare_PagSeguroDireto_Domain_TransactionStatus($data['status']));

    // payment method
    $type = $data['paymentMethod']['type'];
    $code = $data['paymentMethod']['code'];
    $paymentMethod = new Ipagare_PagSeguroDireto_Domain_PaymentMethod($type, $code);
    $payment->setPaymentMethod($paymentMethod);

    if (isset($data['paymentLink'])) {
      $payment->setPaymentLink($data['paymentLink']);
    }
    $payment->setGrossAmount($data['grossAmount']);
    $payment->setDiscountAmount($data['discountAmount']);
    $payment->setFeeAmount($data['feeAmount']);
    $payment->setNetAmount($data['netAmount']);
    $payment->setExtraAmount($data['extraAmount']);
    $payment->setInstallmentCount($data['installmentCount']);

    // cancellationSource
    if (isset($data['cancellationSource'])) {
      $payment->setCancellationSource($data['cancellationSource']);
    }

    return $payment;
  }

  public function getDate() {
    return $this->date;
  }

  public function getLastEventDate() {
    return $this->lastEventDate;
  }

  public function getCode() {
    return $this->code;
  }

  public function getReference() {
    return $this->reference;
  }

  public function getType() {
    return $this->type;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getCancellationSource() {
    return $this->cancellationSource;
  }

  public function getPaymentMethod() {
    return $this->paymentMethod;
  }

  public function getPaymentLink() {
    return $this->paymentLink;
  }

  public function getGrossAmount() {
    return $this->grossAmount;
  }

  public function getDiscountAmount() {
    return $this->discountAmount;
  }

  public function getFeeAmount() {
    return $this->feeAmount;
  }

  public function getNetAmount() {
    return $this->netAmount;
  }

  public function getExtraAmount() {
    return $this->extraAmount;
  }

  public function getEscrowEndDate() {
    return $this->escrowEndDate;
  }

  public function getInstallmentCount() {
    return $this->installmentCount;
  }

  public function setDate($date) {
    $this->date = $date;
  }

  public function setLastEventDate($lastEventDate) {
    $this->lastEventDate = $lastEventDate;
  }

  public function setCode($code) {
    $this->code = $code;
  }

  public function setReference($reference) {
    $this->reference = $reference;
  }

  public function setType(Ipagare_PagSeguroDireto_Domain_TransactionType $type) {
    $this->type = $type;
  }

  public function setStatus(Ipagare_PagSeguroDireto_Domain_TransactionStatus $status) {
    $this->status = $status;
  }

  public function setCancellationSource(Ipagare_PagSeguroDireto_Domain_TransactionCancellationSource $cancellationSource) {
    $this->cancellationSource = $cancellationSource;
  }

  public function setPaymentMethod(Ipagare_PagSeguroDireto_Domain_PaymentMethod $paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  public function setPaymentLink($paymentLink) {
    $this->paymentLink = $paymentLink;
  }

  public function setGrossAmount($grossAmount) {
    $this->grossAmount = $grossAmount;
  }

  public function setDiscountAmount($discountAmount) {
    $this->discountAmount = $discountAmount;
  }

  public function setFeeAmount($feeAmount) {
    $this->feeAmount = $feeAmount;
  }

  public function setNetAmount($netAmount) {
    $this->netAmount = $netAmount;
  }

  public function setExtraAmount($extraAmount) {
    $this->extraAmount = $extraAmount;
  }

  public function setEscrowEndDate($escrowEndDate) {
    $this->escrowEndDate = $escrowEndDate;
  }

  public function setInstallmentCount($installmentCount) {
    $this->installmentCount = $installmentCount;
  }

  public function getXmlReturn() {
    return $this->xmlReturn;
  }

  public function setXmlReturn($xmlReturn) {
    $this->xmlReturn = $xmlReturn;
  }

  public function isSuccess() {
    if (!is_null($this->code)) {
      return true;
    }
  }

}
