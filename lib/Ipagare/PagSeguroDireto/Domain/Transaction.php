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
 * Class Ipagare_PagSeguroDireto_Domain_Transaction
 * Represents a Ipagare_PagSeguroDireto_ transaction
 *
 * @property    Ipagare_PagSeguroDireto_Domain_Sender $sender
 *
 */
class Ipagare_PagSeguroDireto_Domain_Transaction {

  /**
   * Transaction date
   */
  private $date;

  /**
   * Last event date
   * Date the last notification about this transaction was sent
   */
  private $lastEventDate;

  /**
   * Transaction code
   */
  private $code;

  /**
   *  Reference code
   *  You can use the reference code to store an identifier so you can
   *  associate the Ipagare_PagSeguroDireto_ transaction to a transaction in your system.
   */
  private $reference;

  /**
   * Transaction type
   * @see Ipagare_PagSeguroDireto_Domain_TransactionType
   * @var Ipagare_PagSeguroDireto_Domain_TransactionType
   */
  private $type;

  /**
   * Transaction Status
   * @see Ipagare_PagSeguroDireto_Domain_TransactionStatus
   * @var Ipagare_PagSeguroDireto_Domain_TransactionStatus
   */
  private $status;

  /**
   * Payment method
   * @see Ipagare_PagSeguroDireto_Domain_PaymentMethod
   * @var Ipagare_PagSeguroDireto_Domain_PaymentMethod
   */
  private $paymentMethod;

  /**
   * Gross amount of the transaction
   */
  private $grossAmount;

  /**
   * Discount amount
   */
  private $discountAmount;

  /**
   * Fee amount
   */
  private $feeAmount;

  /**
   * Net amount
   */
  private $netAmount;

  /**
   * Extra amount
   */
  private $extraAmount;

  /**
   * Installment count
   */
  private $installmentCount;

  /**
   * item/product list in this transaction
   * @see Ipagare_PagSeguroDireto_Domain_Item
   */
  private $items;

  /**
   * Payer information, who is sending money
   * @see Ipagare_PagSeguroDireto_Domain_Sender
   * @var Ipagare_PagSeguroDireto_Domain_Sender
   */
  private $sender;

  /**
   * Shipping information
   * @see Ipagare_PagSeguroDireto_Domain_Shipping
   * @var Ipagare_PagSeguroDireto_Domain_Shipping
   */
  private $shipping;
  
  
  private $cancellationSource;

  /**
   * Date the last notification about this transaction was sent
   * @return datetime the last event date
   */
  public function getLastEventDate() {
    return $this->lastEventDate;
  }

  /**
   * Sets the last event date
   *
   * @param lastEventDate
   */
  public function setLastEventDate($lastEventDate) {
    $this->lastEventDate = $lastEventDate;
  }

  /**
   * @return datetime the transaction date
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Sets the transaction date
   *
   * @param string date
   */
  public function setDate($date) {
    $this->date = $date;
  }

  /**
   * @return string the transaction code
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Sets the transaction code
   *
   * @param code
   */
  public function setCode($code) {
    $this->code = $code;
  }

  /**
   * You can use the reference code to store an identifier so you can
   *  associate the Ipagare_PagSeguroDireto_ transaction to a transaction in your system.
   *
   * @return string the reference code
   */
  public function getReference() {
    return $this->reference;
  }

  /**
   * Sets the reference code
   *
   * @param reference
   */
  public function setReference($reference) {
    $this->reference = $reference;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_TransactionType the transaction type
   * @see Ipagare_PagSeguroDireto_Domain_TransactionType
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Sets the transaction type
   * @param Ipagare_PagSeguroDireto_Domain_TransactionType $type
   */
  public function setType(Ipagare_PagSeguroDireto_Domain_TransactionType $type) {
    $this->type = $type;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_TransactionStatus the transaction status
   * @see Ipagare_PagSeguroDireto_Domain_TransactionStatus
   */
  public function getStatus() {
    return $this->status;
  }

  /**
   * Sets the transaction status
   * @param Ipagare_PagSeguroDireto_Domain_TransactionStatus $status
   */
  public function setStatus(Ipagare_PagSeguroDireto_Domain_TransactionStatus $status) {
    $this->status = $status;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_PaymentMethod the payment method used in this transaction
   * @see Ipagare_PagSeguroDireto_Domain_PaymentMethod
   */
  public function getPaymentMethod() {
    return $this->paymentMethod;
  }

  /**
   * Sets the payment method used in this transaction
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethod $paymentMethod
   */
  public function setPaymentMethod(Ipagare_PagSeguroDireto_Domain_PaymentMethod $paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * @return float the transaction gross amount
   */
  public function getGrossAmount() {
    return $this->grossAmount;
  }

  /**
   * Sets the transaction gross amount
   * @param float $totalValue
   */
  public function setGrossAmount($totalValue) {
    $this->grossAmount = $totalValue;
  }

  /**
   * @return float the transaction gross amount
   */
  public function getDiscountAmount() {
    return $this->discountAmount;
  }

  /**
   * Sets the transaction gross amount
   * @param float $discountAmount
   */
  public function setDiscountAmount($discountAmount) {
    $this->discountAmount = $discountAmount;
  }

  /**
   * @return float the fee amount
   */
  public function getFeeAmount() {
    return $this->feeAmount;
  }

  /**
   * Sets the transaction fee amount
   * @param float $feeAmount
   */
  public function setFeeAmount($feeAmount) {
    $this->feeAmount = $feeAmount;
  }

  /**
   * @return float the net amount
   */
  public function getNetAmount() {
    return $this->netAmount;
  }

  /**
   * Sets the net amount
   * @param float $netAmount
   */
  public function setNetAmount($netAmount) {
    $this->netAmount = $netAmount;
  }

  /**
   * @return float the extra amount
   */
  public function getExtraAmount() {
    return $this->extraAmount;
  }

  /**
   * Sets the extra amount
   * @param float $extraAmount
   */
  public function setExtraAmount($extraAmount) {
    $this->extraAmount = $extraAmount;
  }

  /**
   * @return integer the installment count
   */
  public function getInstallmentCount() {
    return $this->installmentCount;
  }

  /**
   * Sets the installment count
   * @param integer $installmentCount
   */
  public function setInstallmentCount($installmentCount) {
    $this->installmentCount = $installmentCount;
  }

  /**
   * @return array Ipagare_PagSeguroDireto_Domain_Item the items/products list in this transaction
   * @see Ipagare_PagSeguroDireto_Domain_Item
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Sets the list of items/products in this transaction
   * @param array $items
   * @see Ipagare_PagSeguroDireto_Domain_Item
   */
  public function setItems(array $items) {
    $this->items = $items;
  }

  /**
   * @return integer the items/products count in this transaction
   */
  public function getItemCount() {
    return $this->items == null ? null : count($this->items);
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Sender the sender information, who is sending money in this transaction
   * @see Ipagare_PagSeguroDireto_Domain_Sender
   */
  public function getSender() {
    return $this->sender;
  }

  /**
   * Sets the sender information, who is sending money in this transaction
   * @param Ipagare_PagSeguroDireto_Domain_Sender $sender
   */
  public function setSender(Ipagare_PagSeguroDireto_Domain_Sender $sender) {
    $this->sender = $sender;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Shipping the shipping information
   * @see Ipagare_PagSeguroDireto_Domain_Shipping
   */
  public function getShipping() {
    return $this->shipping;
  }

  /**
   * sets the shipping information for this transaction
   * @param Ipagare_PagSeguroDireto_Domain_Shipping $shipping
   */
  public function setShipping(Ipagare_PagSeguroDireto_Domain_Shipping $shipping) {
    $this->shipping = $shipping;
  }

  public function getCancellationSource() {
    return $this->cancellationSource;
  }

  public function setCancellationSource($cancellationSource) {
    $this->cancellationSource = $cancellationSource;
  }

  /**
   * @return String a string that represents the current object
   */
  public function toString() {

    $transaction = array();
    $transaction['code'] = $this->code;
    $transaction['email'] = $this->sender ? $this->sender->getEmail() : "null";
    $transaction['date'] = $this->date;
    $transaction['reference'] = $this->reference;
    $transaction['status'] = $this->status ? $this->status->getValue() : "null";
    $transaction['itemsCount'] = is_array($this->items) ? count($this->items) : "null";

    $transaction = "Transaction: " . var_export($transaction, true);

    return $transaction;
  }

}
