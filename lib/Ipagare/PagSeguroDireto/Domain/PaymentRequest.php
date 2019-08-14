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
 * Represents a payment request
 */
class Ipagare_PagSeguroDireto_Domain_PaymentRequest {

  /**
   * Party that will be sending the money
   * @var Ipagare_PagSeguroDireto_Domain_Sender
   */
  private $sender;

  /**
   * Payment currency
   */
  private $currency;

  /**
   * Products/items in this payment request
   */
  private $items;

  /**
   * Uri to where the Ipagare_PagSeguroDireto_ payment page should redirect the user after the payment information is processed.
   * Typically this is a confirmation page on your web site.
   * @var String
   */
  private $redirectURL;

  /**
   * Extra amount to be added to the transaction total
   *
   * This value can be used to add an extra charge to the transaction
   * or provide a discount in the case ExtraAmount is a negative value.
   * @var float
   */
  private $extraAmount;

  /**
   * Reference code
   *
   * Optional. You can use the reference code to store an identifier so you can
   * associate the Ipagare_PagSeguroDireto_ transaction to a transaction in your system.
   */
  private $reference;

  /**
   * Shipping information associated with this payment request
   */
  private $shipping;

  /**
   * Billing information associated with this payment request
   * 
   * @var PagSeguroBilling
   */
  private $billing;

  /**
   * Determines for which url Ipagare_PagSeguroDireto_ will send the order related notifications codes.
   *
   * Optional. Any change happens in the transaction status, a new notification request will be send
   * to this url. You can use that for update the related order.
   */
  private $notificationURL;

  /**
   * Extra parameters that user can add to a Ipagare_PagSeguroDireto_ checkout request
   *
   * Optional
   * @var Ipagare_PagSeguroDireto_Domain_Parameter
   */
  private $parameter;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_CreditCardHolder
   */
  private $creditCardHolder;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_Installment 
   */
  private $installment;
  private $creditCardToken;
  private $receiverEmail;
  private $paymentMethod;

  /**
   *
   * @var Ipagare_PagSeguroDireto_Domain_Bank
   */
  private $bank;

  /**
   *
   * @var String
   */
  private $paymentMode = 'default';

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Sender the sender
   *
   * Party that will be sending the Uri to where the Ipagare_PagSeguroDireto_ payment page should redirect the
   * user after the payment information is processed.
   */
  public function getSender() {
    return $this->sender;
  }

  /**
   * Sets the Sender, party that will be sending the money
   * @param String $name
   * @param String $email
   * @param String $areaCode
   * @param String $number
   * @param String $documentType
   * @param String $documentValue
   */
  public function setSender(
  $name, $email = null, $areaCode = null, $number = null, $documentType = null, $documentValue = null
  ) {
    $param = $name;
    if (is_array($param)) {
      $this->sender = new Ipagare_PagSeguroDireto_Domain_Sender($param);
    } elseif ($param instanceof Ipagare_PagSeguroDireto_Domain_Sender) {
      $this->sender = $param;
    } else {
      $sender = new Ipagare_PagSeguroDireto_Domain_Sender();
      $sender->setName($param);
      $sender->setEmail($email);
      $sender->setPhone(new Ipagare_PagSeguroDireto_Domain_Phone($areaCode, $number));
      $sender->addDocument($documentType, $documentValue);
      $this->sender = $sender;
    }
  }

  /**
   * Sets the name of the sender, party that will be sending the money
   * @param String $senderName
   */
  public function setSenderName($senderName) {
    if ($this->sender == null) {
      $this->sender = new Ipagare_PagSeguroDireto_Domain_Sender();
    }
    $this->sender->setName($senderName);
  }

  /**
   * Sets the name of the sender, party that will be sending the money
   * @param String $senderEmail
   */
  public function setSenderEmail($senderEmail) {
    if ($this->sender == null) {
      $this->sender = new Ipagare_PagSeguroDireto_Domain_Sender();
    }
    $this->sender->setEmail($senderEmail);
  }

  /**
   * Sets the Sender phone number, phone of the party that will be sending the money
   *
   * @param areaCode
   * @param number
   */
  public function setSenderPhone($areaCode, $number = null) {
    $param = $areaCode;
    if ($this->sender == null) {
      $this->sender = new Ipagare_PagSeguroDireto_Domain_Sender();
    }
    if ($param instanceof Ipagare_PagSeguroDireto_Domain_Phone) {
      $this->sender->setPhone($param);
    } else {
      $this->sender->setPhone(new Ipagare_PagSeguroDireto_Domain_Phone($param, $number));
    }
  }

  /**
   * @return String the currency
   * Example: BRL
   */
  public function getCurrency() {
    return $this->currency;
  }

  /**
   * Sets the currency
   * @param String $currency
   */
  public function setCurrency($currency) {
    $this->currency = $currency;
  }

  /**
   * @return array the items/products list in this payment request
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Sets the items/products list in this payment request
   * @param array $items
   */
  public function setItems(array $items) {
    if (is_array($items)) {
      $i = array();
      foreach ($items as $key => $item) {
        if ($item instanceof Ipagare_PagSeguroDireto_Domain_Item) {
          $i[$key] = $item;
        } else {
          if (is_array($item)) {
            $i[$key] = new Ipagare_PagSeguroDireto_Domain_Item($item);
          }
        }
      }
      $this->items = $i;
    }
  }

  /**
   * Adds a new product/item in this payment request
   *
   * @param String $id
   * @param String $description
   * @param String $quantity
   * @param String $amount
   * @param String $weight
   * @param String $shippingCost
   */
  public function addItem(
  $id, $description = null, $quantity = null, $amount = null, $weight = null, $shippingCost = null
  ) {
    $param = $id;
    if ($this->items == null) {
      $this->items = array();
    }
    if (is_array($param)) {
      array_push($this->items, new Ipagare_PagSeguroDireto_Domain_Item($param));
    } else {
      if ($param instanceof Ipagare_PagSeguroDireto_Domain_Item) {
        array_push($this->items, $param);
      } else {
        $item = new Ipagare_PagSeguroDireto_Domain_Item();
        $item->setId($param);
        $item->setDescription($description);
        $item->setQuantity($quantity);
        $item->setAmount($amount);
        $item->setWeight($weight);
        $item->setShippingCost($shippingCost);
        array_push($this->items, $item);
      }
    }
  }

  public function addSenderDocument($type, $value) {
    if ($this->getSender() instanceof Ipagare_PagSeguroDireto_Domain_Sender) {
      $this->getSender()->addDocument($type, $value);
    }
  }

  /**
   * URI to where the Ipagare_PagSeguroDireto_ payment page should redirect the user after the payment information is processed.
   * Typically this is a confirmation page on your web site.
   *
   * @return String the redirectURL
   */
  public function getRedirectURL() {
    return $this->redirectURL;
  }

  /**
   * Sets the redirect URL
   *
   * Uri to where the Ipagare_PagSeguroDireto_ payment page should redirect the user after the payment information is processed.
   * Typically this is a confirmation page on your web site.
   *
   * @param String $redirectURL
   */
  public function setRedirectURL($redirectURL) {
    $this->redirectURL = $this->verifyURLTest($redirectURL);
  }

  /**
   * This value can be used to add an extra charge to the transaction
   * or provide a discount in the case ExtraAmount is a negative value.
   *
   * @return float the extra amount
   */
  public function getExtraAmount() {
    return $this->extraAmount;
  }

  /**
   * Sets the extra amount
   * This value can be used to add an extra charge to the transaction
   * or provide a discount in the case <b>extraAmount</b> is a negative value.
   *
   * @param extraAmount
   */
  public function setExtraAmount($extraAmount) {
    $this->extraAmount = $extraAmount;
  }

  /**
   * @return mixed the reference of this payment request
   */
  public function getReference() {
    return $this->reference;
  }

  /**
   * Sets the reference of this payment request
   * @param reference
   */
  public function setReference($reference) {
    $this->reference = $reference;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Shipping the shipping information for this payment request
   * @see Ipagare_PagSeguroDireto_Domain_Shipping
   */
  public function getShipping() {
    return $this->shipping;
  }

  /**
   * Sets the shipping information for this payment request
   * @param Ipagare_PagSeguroDireto_Domain_Shipping $address
   * @param Ipagare_PagSeguroDireto_Domain_ShippingType $type
   */
  public function setShipping($address, $type = null) {
    $param = $address;
    if ($param instanceof Ipagare_PagSeguroDireto_Domain_Shipping) {
      $this->shipping = $param;
    } else {
      $shipping = new Ipagare_PagSeguroDireto_Domain_Shipping();
      if (is_array($param)) {
        $shipping->setAddress(new Ipagare_PagSeguroDireto_Domain_Address($param));
      } else {
        if ($param instanceof Ipagare_PagSeguroDireto_Domain_Address) {
          $shipping->setAddress($param);
        }
      }
      if ($type) {
        if ($type instanceof Ipagare_PagSeguroDireto_Domain_ShippingType) {
          $shipping->setType($type);
        } else {
          $shipping->setType(new Ipagare_PagSeguroDireto_Domain_ShippingType($type));
        }
      }
      $this->shipping = $shipping;
    }
  }

  /**
   * Sets the shipping address for this payment request
   * @param String $postalCode
   * @param String $street
   * @param String $number
   * @param String $complement
   * @param String $district
   * @param String $city
   * @param String $state
   * @param String $country
   */
  public function setShippingAddress(
  $postalCode = null, $street = null, $number = null, $complement = null, $district = null, $city = null, $state = null, $country = null
  ) {
    $param = $postalCode;
    if ($this->shipping == null) {
      $this->shipping = new Ipagare_PagSeguroDireto_Domain_Shipping();
    }
    if (is_array($param)) {
      $this->shipping->setAddress(new Ipagare_PagSeguroDireto_Domain_Address($param));
    } elseif ($param instanceof Ipagare_PagSeguroDireto_Domain_Address) {
      $this->shipping->setAddress($param);
    } else {
      $address = new Ipagare_PagSeguroDireto_Domain_Address();
      $address->setPostalCode($postalCode);
      $address->setStreet($street);
      $address->setNumber($number);
      $address->setComplement($complement);
      $address->setDistrict($district);
      $address->setCity($city);
      $address->setState($state);
      $address->setCountry($country);
      $this->shipping->setAddress($address);
    }
  }

  /**
   * Sets the shipping type for this payment request
   * @param Ipagare_PagSeguroDireto_Domain_ShippingType $type
   */
  public function setShippingType($type) {
    $param = $type;
    if ($this->shipping == null) {
      $this->shipping = new Ipagare_PagSeguroDireto_Domain_Shipping();
    }
    if ($param instanceof Ipagare_PagSeguroDireto_Domain_ShippingType) {
      $this->shipping->setType($param);
    } else {
      $this->shipping->setType(new Ipagare_PagSeguroDireto_Domain_ShippingType($param));
    }
  }

  /**
   * Sets the shipping cost for this payment request
   * @param float $shippingCost
   */
  public function setShippingCost($shippingCost) {
    $param = $shippingCost;
    if ($this->shipping == null) {
      $this->shipping = new Ipagare_PagSeguroDireto_Domain_Shipping();
    }

    $this->shipping->setCost($param);
  }

  /**
   * Get the notification status url
   *
   * @return String
   */
  public function getNotificationURL() {
    return $this->notificationURL;
  }

  /**
   * Sets the url that Ipagare_PagSeguroDireto_ will send the new notifications statuses
   *
   * @param String $notificationURL
   */
  public function setNotificationURL($notificationURL) {
    $this->notificationURL = $this->verifyURLTest($notificationURL);
  }

  /**
   * Sets parameter for Ipagare_PagSeguroDireto_ checkout requests
   *
   * @param Ipagare_PagSeguroDireto_Domain_Parameter $parameter
   */
  public function setParameter($parameter) {
    $this->parameter = $parameter;
  }

  /**
   * Gets parameter for Ipagare_PagSeguroDireto_ checkout requests
   *
   * @return Ipagare_PagSeguroDireto_Domain_Parameter
   */
  public function getParameter() {
    if ($this->parameter == null) {
      $this->parameter = new Ipagare_PagSeguroDireto_Domain_Parameter();
    }
    return $this->parameter;
  }

  /**
   * add a parameter for Ipagare_PagSeguroDireto_ checkout request
   *
   * @param Ipagare_PagSeguroDireto_Domain_ParameterItem $parameterName key
   * @param Ipagare_PagSeguroDireto_Domain_ParameterItem $parameterValue value
   */
  public function addParameter($parameterName, $parameterValue) {
    $this->getParameter()->addItem(new Ipagare_PagSeguroDireto_Domain_ParameterItem($parameterName, $parameterValue));
  }

  public function register(Ipagare_PagSeguroDireto_Domain_Credentials $credentials) {
    $paymentService = new Ipagare_PagSeguroDireto_Service_PaymentService();
    return $paymentService->createTransaction($credentials, $this);
  }

  /**
   * @return String a string that represents the current object
   */
  public function toString() {
    $email = $this->sender ? $this->sender->getEmail() : "null";

    $request = array();
    $request['Reference'] = $this->reference;
    $request['SenderEmail'] = $email;

    return "Ipagare_PagSeguroDireto_Domain_PaymentRequest: " . var_export($request, true);
  }

  /**
   * Verify if the adress of NotificationURL or RedirectURL is for tests and return empty
   * @param type $url
   * @return type
   */
  public function verifyURLTest($url) {
    $adress = array(
        'localhost',
        '127.0.0.1',
        '::1'
    );

    $urlReturn;
    foreach ($adress as $item) {
      $find = strpos($url, $item);

      if ($find) {
        $urlReturn = '';
        break;
      } else {
        $urlReturn = $url;
      }
    }

    return $urlReturn;
  }

  public function getCreditCardHolder() {
    return $this->creditCardHolder;
  }

  public function setCreditCardHolder($creditCardHolder) {
    $this->creditCardHolder = $creditCardHolder;
  }

  public function getCreditCardToken() {
    return $this->creditCardToken;
  }

  public function getReceiverEmail() {
    return $this->receiverEmail;
  }

  public function getPaymentMethod() {
    return $this->paymentMethod;
  }

  public function getPaymentMode() {
    return $this->paymentMode;
  }

  public function setCreditCardToken($creditCardToken) {
    $this->creditCardToken = $creditCardToken;
  }

  public function setReceiverEmail($receiverEmail) {
    $this->receiverEmail = $receiverEmail;
  }

  public function setPaymentMethod($paymentMethod) {
    $this->paymentMethod = $paymentMethod;
  }

  public function setPaymentMode($paymentMode) {
    $this->paymentMode = $paymentMode;
  }

  public function getBilling() {
    return $this->billing;
  }

  public function setBilling($address) {
    $param = $address;
    if ($param instanceof Ipagare_PagSeguroDireto_Domain_Billing) {
      $this->billing = $param;
    } else {
      $billing = new Ipagare_PagSeguroDireto_Domain_Billing();
      if (is_array($param)) {
        $billing->setAddress(new Ipagare_PagSeguroDireto_Domain_Address($param));
      } else {
        if ($param instanceof Ipagare_PagSeguroDireto_Domain_Address) {
          $billing->setAddress($param);
        }
      }
      $this->billing = $billing;
    }
  }

  public function getInstallment() {
    return $this->installment;
  }

  public function setInstallment(Ipagare_PagSeguroDireto_Domain_Installment $installment) {
    $this->installment = $installment;
  }

  public function getBank() {
    return $this->bank;
  }

  public function setBank(Ipagare_PagSeguroDireto_Domain_Bank $bank) {
    $this->bank = $bank;
  }

}
