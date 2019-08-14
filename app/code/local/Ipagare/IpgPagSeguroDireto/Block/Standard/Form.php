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

class Ipagare_IpgPagSeguroDireto_Block_Standard_Form extends Mage_Payment_Block_Form {

  private $paymentTypeOptions;

  protected function _construct() {
    $this->setTemplate('ipagare/ipgpagsegurodireto/payment/form.phtml');
    parent::_construct();
  }

  protected function _prepareLayout() {
    return parent::_prepareLayout();
  }

  public function hasCreditCard() {
    if (count($this->paymentTypeOptions->getOptions()) < 1) {
      return false;
    }
    foreach ($this->paymentTypeOptions->getOptions() as $paymentTypeOption) {
      $paymentType = $paymentTypeOption->getPaymentType();
      if ($paymentType->isCreditCard()) {
        return true;
      }
    }
    return false;
  }

  public function hasErrors() {
    return $this->paymentTypeOptions->hasErrors();
  }

  public function hasBoleto() {
    if (count($this->paymentTypeOptions->getOptions()) < 1) {
      return false;
    }
    foreach ($this->paymentTypeOptions->getOptions() as $paymentTypeOption) {
      $paymentType = $paymentTypeOption->getPaymentType();
      if ($paymentType->isBoleto()) {
        return true;
      }
    }
    return false;
  }

  public function hasTransferencia() {
    if (count($this->paymentTypeOptions->getOptions()) < 1) {
      return false;
    }
    foreach ($this->paymentTypeOptions->getOptions() as $paymentTypeOption) {
      $paymentType = $paymentTypeOption->getPaymentType();
      if ($paymentType->isDebitoBancario()) {
        return true;
      }
    }
    return false;
  }

  public function mountPaymentTypeOptions() {
    $valorTotal = Mage::getSingleton('checkout/session')->getQuote()->getBaseGrandTotal();
    $this->paymentTypeOptions = Mage::getModel('ipgpagsegurodireto/paymentType')->getPaymentTypeOptions($valorTotal);
  }

  public function getPaymentTypeOptions() {
    return $this->paymentTypeOptions;
  }

  public function isTeleVendasActive() {
    if (Mage::helper('ipgbase/module')->isTeleVendasExists()) {
      return true;
    }
    return false;
  }

  public function getSessionId() {
    return Mage::getModel('ipgpagsegurodireto/credential')->getSessionId();
  }

  public function isCustomCssEnabled() {
    return Mage::getStoreConfigFlag(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CUSTOM_CSS);
  }

}
