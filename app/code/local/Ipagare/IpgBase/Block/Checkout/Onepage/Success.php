<?php

/**
* 
* iPAGARE para Magento
* 
* @category     Ipagare
* @packages     IpgBase
* @copyright    Copyright (c) 2012 iPAGARE (http://www.ipagare.com.br)
* @version      1.16.4
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

class Ipagare_IpgBase_Block_Checkout_Onepage_Success extends Mage_Checkout_Block_Onepage_Success {

  private $paymentMethod;
  private $isIpagareMethod;

  protected function _construct() {
    parent::_construct();
    $this->setPaymentMethod();

    $this->isIpagareMethod = Mage::helper('ipgbase')->isIpagarePaymentMethod($this->paymentMethod);
    if ($this->isIpagareMethod) {
      $this->setTemplate('ipagare/' . $this->paymentMethod . '/checkout/success-details.phtml');
    }
  }

  public function getBlock() {
    if ($this->isIpagareMethod) {
      $block = $this->getLayout()->getBlockSingleton($this->paymentMethod . '/checkout_onepage_success');
      if ($block) {
        return $block;
      }
    }
    return null;
  }

  private function setPaymentMethod() {
    $order = Mage::helper('ipgbase/session')->getCurrentOrder();
    $payment = $order->getPayment();
    $method = $payment->getMethodInstance();
    $this->paymentMethod = $payment->getMethodInstance()->getCode();
  }

}
