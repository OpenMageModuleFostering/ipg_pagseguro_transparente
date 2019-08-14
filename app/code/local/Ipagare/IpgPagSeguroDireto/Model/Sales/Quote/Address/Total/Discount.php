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

class Ipagare_IpgPagSeguroDireto_Model_Sales_Quote_Address_Total_Discount extends Mage_Sales_Model_Quote_Address_Total_Abstract {

  protected $_code = 'discount-ipgpagsegurodireto';

  public function collect(Mage_Sales_Model_Quote_Address $address) {
    parent::collect($address);
    $this->_setAmount(0);
    $this->_setBaseAmount(0);
    $address->setIpgPagsegurodiretoDiscountAmount(0);
    $address->setIpgPagsegurodiretoBaseDiscountAmount(0);

    $items = $this->_getAddressItems($address);
    if (!count($items)) {
      return $this;
    }

    $discount = Mage::getSingleton('ipgpagsegurodireto/discount');
    if ($discount->canApply($address)) {
      $paymentDiscount = $discount->getDiscount();

      $baseTotalDiscountAmount = round((($paymentDiscount->baseSubtotalWithDiscount + $paymentDiscount->baseTax) * $paymentDiscount->totalPercent) / 100, 2);

      $totalDiscountAmount = Mage::helper('directory')->currencyConvert($baseTotalDiscountAmount, $paymentDiscount->baseCurrencyCode);
      $address->setIpgPagsegurodiretoDiscountAmount(-$totalDiscountAmount);
      $address->setIpgPagsegurodiretoBaseDiscountAmount(-$baseTotalDiscountAmount);
      $address->setGrandTotal($address->getGrandTotal() + $address->getIpgPagsegurodiretoDiscountAmount());
      $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getIpgPagsegurodiretoBaseDiscountAmount());
    }

    return $this;
  }

  public function fetch(Mage_Sales_Model_Quote_Address $address) {
    $amount = $address->getIpgPagsegurodiretoDiscountAmount();
    if ($amount < 0) {
      $address->addTotal(array('code' => $this->getCode(),
          'title' => Mage::helper('ipgbase')->__('Payment Discount'),
          'value' => $amount
      ));
    }
    return $this;
  }

}
