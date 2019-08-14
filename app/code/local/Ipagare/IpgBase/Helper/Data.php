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

class Ipagare_IpgBase_Helper_Data extends Mage_Core_Helper_Abstract {

  /**
   * Verifica se o método de pagamento consta na lista de Payment Methods desenvolvidos pelo iPAGARE.
   * 
   * @return type boolean
   */
  public function isIpagarePaymentMethod($paymentMethodCode) {
    return in_array($paymentMethodCode, Ipagare_IpgBase_Config::listPaymentMethods());
  }

  /**
   * Retorna a lista com os métodos de pagamentos
   * 
   * @return type array
   */
  public function listPaymentMethods() {
    return Ipagare_IpgBase_Config::listPaymentMethods();
  }

  public function isOscCssEnabled() {
    return Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::OSC_CSS_ACTIVE);
  }

  public function canSendEmail(Mage_Sales_Model_Order $order) {
    if ($order->getState() == Mage_Sales_Model_Order::STATE_CANCELED) {
      if (Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::CONTROLE_ENVIO_EMAIL_CANCELADO)) {
        return true;
      }
    }
    if ($order->getState() == Mage_Sales_Model_Order::STATE_NEW) {
      if (Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::CONTROLE_ENVIO_EMAIL_NOVO)) {
        return true;
      }
    }
    if ($order->getState() == Mage_Sales_Model_Order::STATE_PROCESSING || $order->getState() == Mage_Sales_Model_Order::STATE_COMPLETE) {
      if (Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::CONTROLE_ENVIO_EMAIL_FATURA_GERADA)) {
        return true;
      }
    }
    return false;
  }

  public function isUrlTelevendas() {
    $currentUrl = Mage::helper('core/url')->getCurrentUrl();
    if (preg_match('/ipgtelevendas/', $currentUrl)) {
      return true;
    }
    return false;
  }

  public function addStatusHistoryComment($order, $message, $notified = false) {
    $order->addStatusHistoryComment($message, false)->setIsCustomerNotified($notified);
    $order->save();
  }

  public function getStoreConfig($value, $store = null) {
    return trim(Mage::getStoreConfig($value, $store));
  }

  public function getPaymentMethodCode() {
    $order = Mage::helper('ipgbase/session')->getCurrentOrder();
    $payment = $order->getPayment();
    return $payment->getMethodInstance()->getCode();
  }

  /**
   * Retorna apenas os números.
   * 
   */
  public function getOnlyNumbers($entry) {
    return preg_replace('/\D/', '', $entry);
  }

}
