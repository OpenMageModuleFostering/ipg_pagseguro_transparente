<?php

/**
* 
* iPAGARE PagSeguro para Magento
* 
* @category     Ipagare
* @packages     IpgPagSeguroDireto
* @copyright    Copyright (c) 2014 iPAGARE (http://www.ipagare.com.br)
* @version      1.1.3
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

class Ipagare_IpgPagSeguroDireto_Model_Payment extends Mage_Core_Model_Abstract {

  private $logger;

  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * 
   * @param Mage_Sales_Model_Order $order
   * @param Ipagare_PagSeguroDireto_Domain_PaymentMethodCode
   * @return Ipagare_PagSeguroDireto_Domain_PaymentResponse
   */
  public function pay(Mage_Sales_Model_Order $order, Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType) {
    $this->logger->info('Início criação da transação do pedido ' . $order->getIncrementId());

    $credentials = Mage::getSingleton('ipgpagsegurodireto/credential')->getAccountCredentials();
    $paymentRequest = $this->generatePaymentRequest($order, $paymentType);
    return $paymentRequest->register($credentials);
  }

  protected function generatePaymentRequest(Mage_Sales_Model_Order $order, Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType) {
    $paymentRequest = new Ipagare_PagSeguroDireto_Domain_PaymentRequest();

    /* reference */
    $paymentRequest->setReference($order->getIncrementId());

    /* Currency */
    $paymentRequest->setCurrency(Ipagare_PagSeguroDireto_Domain_Currencies::getIsoCodeByName('REAL'));

    /* Extra amount */
    $paymentRequest->setExtraAmount($this->getExtraAmountValues($order));

    /* Products */
    $paymentRequest->setItems($this->generateProductsData($order));

    /* Sender */
    $paymentRequest->setSender($this->generateSenderData($order));

    /* Shipping */
    $paymentRequest->setShipping($this->generateShippingData($order));

    /* Billing */
    $paymentRequest->setBilling($this->generateBillingData($order));

    $sessionCoreMage = Mage::getSingleton('ipgbase/session');
    $paymentMethod = $sessionCoreMage->getPagSeguroPaymentMethod();
    if ($paymentMethod == 'creditCard') {
      $creditCardToken = $sessionCoreMage->getPagSeguroCreditCardToken();
      $installmentQuantity = $sessionCoreMage->getPagSeguroInstallmentQuantity();

      $paymentRequest->setCreditCardToken($creditCardToken);
      $paymentRequest->setCreditCardHolder($this->generateCreditCardHolder());

      /**
       * Installment
       */
      $installmentValue = $sessionCoreMage->getPagSeguroInstallmentValue();
      $installmentValue = number_format(round($installmentValue, 2), 2, '.', '');
      $installment = array('quantity' => $installmentQuantity, 'value' => $installmentValue);
      $paymentRequest->setInstallment(new Ipagare_PagSeguroDireto_Domain_Installment($installment));
    } else if ($paymentMethod == 'eft') {
      $paymentRequest->setBank($this->generateBank($paymentType));
    }
    /* receiver email */
    $receiverEmail = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::EMAIL);
    $paymentRequest->setReceiverEmail($receiverEmail);

    /* payment method */
    $paymentRequest->setPaymentMethod($paymentMethod);

    /* payment mode */
    $paymentRequest->setPaymentMode('default');

    return $paymentRequest;
  }

  /**
   * Gets extra amount values for order
   *
   * @return float
   */
  private function getExtraAmountValues(Mage_Sales_Model_Order $order) {
    $addition = 0.00;
    $discount = 0.00;
    if ($order->getBaseDiscountAmount()) {
      $discount += $order->getBaseDiscountAmount();
    }
    if ($order->getIpgPagsegurodiretoBaseDiscountAmount()) {
      $discount += $order->getIpgPagsegurodiretoBaseDiscountAmount();
    }
    // Afiliates Mage Store (www.magestore.com/affiliateplus/)
    if ($order->getBaseAffiliateplusDiscount()) {
      $discount += $order->getBaseAffiliateplusDiscount();
    }
    if ($order->getBaseTaxAmount()) {
      $addition = $order->getBaseTaxAmount();
    }
    $amount = $addition + $discount;

    return round($amount, 2);
  }

  /**
   * Generates products data to PagSeguro transaction
   *
   * @return Array PagSeguroItem
   */
  private function generateProductsData(Mage_Sales_Model_Order $order) {
    $pagseguroItems = array();
    $count = 0;

    foreach ($order->getAllItems() as $itemId => $item) {
      $qtd = $item->getQtyToInvoice();
      $basePrice = round($item->getBasePrice(), 2);
      if (!empty($qtd) && $basePrice > 0) {
        $pagSeguroItem = new Ipagare_PagSeguroDireto_Domain_Item();
        $pagSeguroItem->setId($item->getProductId());
        $pagSeguroItem->setDescription(substr($item->getName(), 0, 100));
        $pagSeguroItem->setQuantity($qtd);

        $pagSeguroItem->setAmount($basePrice);
        //$pagSeguroItem->setWeight();
        //$pagSeguroItem->setShippingCost();

        $pagseguroItems[$count++] = $pagSeguroItem;
      }
    }


    /**
     * Taxas
     * 
     * Obs.: foi passado pro ExtraAmount
     */
    /*
      if ($order->getBaseTaxAmount() > 0) {
      $pagSeguroItem = new Ipagare_PagSeguroDireto_Domain_Item();
      $pagSeguroItem->setId('TX-0001');
      $pagSeguroItem->setDescription(substr('Taxas', 0, 255));
      $pagSeguroItem->setQuantity(1);

      $pagSeguroItem->setAmount(round($order->getBaseTaxAmount(), 2));

      $pagseguroItems[$count++] = $pagSeguroItem;
      }
     */

    // frete
    if ($order->getBaseShippingAmount() > 0) {
      $pagSeguroItem = new Ipagare_PagSeguroDireto_Domain_Item();
      $pagSeguroItem->setId('FR-0003');
      $pagSeguroItem->setDescription(substr('Frete', 0, 100));
      $pagSeguroItem->setQuantity(1);

      $pagSeguroItem->setAmount(round($order->getBaseShippingAmount(), 2));

      $pagseguroItems[$count++] = $pagSeguroItem;
    }
    return $pagseguroItems;
  }

  /**
   * Generates sender data to PagSeguro transaction
   *
   * @return PagSeguroSender
   */
  private function generateSenderData(Mage_Sales_Model_Order $order) {
    $sender = new Ipagare_PagSeguroDireto_Domain_Sender();

    $senderName = trim($order->getCustomerFirstname()) . ' ' . ($order->getCustomerMiddlename() != null ? trim($order->getCustomerMiddlename()) . ' ' : '') . trim($order->getCustomerLastname());
    $sender->setName(substr($senderName, 0, 50));

    $senderCPF = $order->getCustomerTaxvat();
    $senderCPF = Mage::helper('ipgbase')->getOnlyNumbers($senderCPF);

    if ($order->getCustomerTipoPessoa() != null && $order->getCustomerTipoPessoa() == 'J') {
      $sender->addDocument('cnpj', $senderCPF);
    } else {
      $sender->addDocument('cpf', $senderCPF);
    }
    // telefone
    $billingAddress = $order->getBillingAddress();
    $telephone = Mage::helper('ipgbase')->getOnlyNumbers($billingAddress->getTelephone());
    $areaCode = substr($telephone, 0, 2);
    $phoneNumber = substr($telephone, 2);
    $sender->setPhone($areaCode, $phoneNumber);

    /**
     * Se utilizar o SandBox é preciso informar o e-mail contendo "@sandbox.pagseguro.com.br"
     */
    $senderEmail = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::SENDER_EMAIL);
    if ($senderEmail != null) {
      $sender->setEmail($senderEmail);
    } else {
      $sender->setEmail($order->getCustomerEmail());
    }
    // hash
    $sessionCoreMage = Mage::getSingleton('ipgbase/session');
    $hash = $sessionCoreMage->getSenderHash();
    $sender->setHash($hash);

    return $sender;
  }

  private function generateBank(Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType) {
    $bank = new Ipagare_PagSeguroDireto_Domain_Bank();
    $bank->setName($paymentType->getBandeira());

    return $bank;
  }

  private function generateCreditCardHolder() {
    $sessionCoreMage = Mage::getSingleton('ipgbase/session');
    $name = $sessionCoreMage->getNomePortador();
    $cpf = $sessionCoreMage->getCpfPortador();
    $cpf = Mage::helper('ipgbase')->getOnlyNumbers($cpf);
    $birthday = $sessionCoreMage->getDataNascimentoPortador();
    $areaCode = $sessionCoreMage->getAreaCodePortador();
    $phoneNumber = $sessionCoreMage->getFoneNumberPortador();

    $creadiCardHolder = new Ipagare_PagSeguroDireto_Domain_CreditCardHolder();
    $creadiCardHolder->setName(substr($name, 0, 50));
    $creadiCardHolder->setCpf($cpf);
    $creadiCardHolder->setBirthDate($birthday);
    
    $areaCode = Mage::helper('ipgbase')->getOnlyNumbers($areaCode);
    $creadiCardHolder->setAreaCode($areaCode);
    $phoneNumber = Mage::helper('ipgbase')->getOnlyNumbers($phoneNumber);
    $creadiCardHolder->setPhone($phoneNumber);

    return $creadiCardHolder;
  }

  private function generateBillingData(Mage_Sales_Model_Order $order) {
    $billing = new Ipagare_PagSeguroDireto_Domain_Billing();
    $billing->setAddress($this->generateBillingAddressData($order));

    return $billing;
  }

  /**
   * Generates billing address data to PagSeguro transaction
   *
   * @return Ipagare_PagSeguroDireto_Domain_Address
   */
  private function generateBillingAddressData(Mage_Sales_Model_Order $order) {
    $billingAddress = $order->getBillingAddress();

    $address = new Ipagare_PagSeguroDireto_Domain_Address();
    $address->setCity($billingAddress->getCity());
    $address->setPostalCode($billingAddress->getPostcode());

    $street = substr($billingAddress->getStreet(1), 0, 80);
    $address->setStreet($street);

    $number = substr($billingAddress->getStreet(2), 0, 20);
    $address->setNumber($number);

    $complement = substr($billingAddress->getStreet(3), 0, 40);
    $address->setComplement($complement);

    $district = substr($billingAddress->getStreet(4), 0, 60);
    $address->setDistrict($district);

    $country = $billingAddress->getCountryModel();
    $address->setCountry($country->getIso3Code());
    $address->setState($billingAddress->getRegionCode());

    return $address;
  }

  private function generateShippingData(Mage_Sales_Model_Order $order) {
    $shipping = new Ipagare_PagSeguroDireto_Domain_Shipping();
    $shipping->setAddress($this->generateShippingAddressData($order));

    return $shipping;
  }

  /**
   * Generates shipping address data to PagSeguro transaction
   *
   * @return Ipagare_PagSeguroDireto_Domain_Address
   */
  private function generateShippingAddressData(Mage_Sales_Model_Order $order) {
    $shippingAddress = null;
    if ($order->getIsVirtual()) {
      $shippingAddress = $order->getBillingAddress();
    } else {
      $shippingAddress = $order->getShippingAddress();
    }

    $address = new Ipagare_PagSeguroDireto_Domain_Address();
    $address->setCity($shippingAddress->getCity());
    $address->setPostalCode($shippingAddress->getPostcode());

    $street = substr($shippingAddress->getStreet(1), 0, 80);
    $address->setStreet($street);

    $number = substr($shippingAddress->getStreet(2), 0, 20);
    $address->setNumber($number);

    $complement = substr($shippingAddress->getStreet(3), 0, 40);
    $address->setComplement($complement);

    $district = substr($shippingAddress->getStreet(4), 0, 60);
    $address->setDistrict($district);

    $country = $shippingAddress->getCountryModel();
    $address->setCountry($country->getIso3Code());
    $address->setState($shippingAddress->getRegionCode());

    return $address;
  }

  public function save(Ipagare_PagSeguroDireto_Parser_PaymentParserData $paymentParserData, Ipagare_IpgPagSeguroDireto_PaymentMode $paymentMode) {
    $payment = Mage::getModel('ipgpagsegurodireto/entity_payment');
    $payment->loadByAttribute('order_id', $paymentParserData->getReference());

    if (Mage::helper('ipgbase/stringUtils')->isEmpty($payment->getOrderId())) {
      $payment->setOrderId($paymentParserData->getReference());
      $payment->setTransactionCode($paymentParserData->getCode());
      $payment->setMeioPagamento($paymentParserData->getPaymentMethod()->getCode()->getValue());
      $payment->setFormaPagamento($paymentMode->getCodigo());
      $payment->setValorTotal($paymentParserData->getGrossAmount());

      $payment->setStatus($paymentParserData->getStatus()->getCode());
      $payment->setPaymentLink($paymentParserData->getPaymentLink());
      $payment->setCreatedTime(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));

      $payment->save();
    }
  }

  public function saveError($errorCode, $orderId) {
    $erro = Mage::getModel('ipgpagsegurodireto/entity_erro');
    $erro->loadByAttribute('order_id', $orderId);

    if (Mage::helper('ipgbase/stringUtils')->isEmpty($erro->getOrderId())) {
      $erro->setOrderId($orderId);
      $erro->setCode($errorCode);

      $erro->save();
    }
  }

  public function hasPayment($orderId) {
    $pagamento = Mage::getModel('ipgpagsegurodireto/entity_payment');
    $pagamento->loadByAttribute('order_id', $orderId);

    if (Mage::helper('ipgbase/stringUtils')->isEmpty($pagamento->getOrderId())) {
      return false;
    }
    return true;
  }

}
