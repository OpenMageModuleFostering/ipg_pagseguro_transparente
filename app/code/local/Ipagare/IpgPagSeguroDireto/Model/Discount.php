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

class Ipagare_IpgPagSeguroDireto_Model_Discount extends Mage_Core_Model_Abstract {

  public function canApply($address) {
    $data = Mage::app()->getRequest()->getPost('payment', array());
    if (!count($data) || !isset($data['type'])) {
      return false;
    }

    $currentPaymentMethod = null;
    $paymentType = null;
    $paymentMode = null;

    if (isset($data['type'])) {
      $arrayex = explode('_', $data['type']);
      if (isset($arrayex[0]) && isset($arrayex[1])) {
        $paymentType = $arrayex[0];
        $paymentMode = $arrayex[1];
      }
    }

    $sessionQuote = Mage::getSingleton('checkout/session')->getQuote();
    if ($sessionQuote->getPayment() != null && $sessionQuote->getPayment()->hasMethodInstance()) {
      $currentPaymentMethod = $sessionQuote->getPayment()->getMethodInstance()->getCode();
    } elseif (isset($data['method'])) {
      $currentPaymentMethod = $data['method'];
    }
    
    if ($currentPaymentMethod == 'ipgpagsegurodireto' && $paymentType != null && $paymentMode == Ipagare_IpgPagSeguroDireto_PaymentMode::A01) {
      return true;
    }

    return false;
  }

  public function getDiscount() {
    $data = Mage::app()->getRequest()->getPost('payment', array());

    $paymentType = null;
    if (isset($data['type'])) {
      $arrayex = explode('_', $data['type']);
      if (isset($arrayex[0]) && isset($arrayex[1])) {
        $paymentType = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($arrayex[0]);
      }
    }

    $descontoAvista = str_replace(',', '.', Mage::getModel('ipgpagsegurodireto/paymentMath')->getDescontoAvista($paymentType));
    $baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
    $baseSubtotalWithDiscount = 0;
    $baseTax = 0;

    $sessionQuote = Mage::getSingleton('checkout/session')->getQuote();
    if ($sessionQuote->isVirtual()) {
      $address = $sessionQuote->getBillingAddress();
    } else {
      $address = $sessionQuote->getShippingAddress();
    }
    if ($address) {
      $baseSubtotalWithDiscount = $address->getBaseSubtotalWithDiscount();
      $baseTax = $address->getBaseTaxAmount();
    }
    
    return Ipagare_IpgBase_PaymentDiscount::getInstance($baseCurrencyCode, $descontoAvista, $baseSubtotalWithDiscount, $baseTax);
  }

  public function getIpgDiscount($order) {
    return $order->getIpgPagsegurodiretoDiscountAmount();
  }

  public function getIpgBaseDiscount($order) {
    return $order->getIpgPagsegurodiretoBaseDiscountAmount();
  }

  public function getIpgDiscountCode() {
    return 'discount-ipgpagsegurodireto';
  }

}
