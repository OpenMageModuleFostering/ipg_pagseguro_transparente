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

Mage::helper('ipgpagsegurodireto')->getPagSeguroLibrary();

class Ipagare_IpgPagSeguroDireto_Model_IpgPagSeguroDireto extends Mage_Payment_Model_Method_Abstract {

  private $logger;

  /**
   * rewrited for Mage_Payment_Model_Method_Abstract
   */
  protected $_code = 'ipgpagsegurodireto';
  protected $_isGateway = true;
  protected $_canAuthorize = true;
  protected $_canCapture = true;
  protected $_canCapturePartial = false;
  protected $_canRefund = true;
  protected $_canVoid = true;
  protected $_canUseInternal = true;
  protected $_canUseCheckout = true;
  protected $_canUseForMultishipping = true;
  protected $_isInitializeNeeded = true;
  protected $_formBlockType = 'ipgpagsegurodireto/standard_form';
  protected $_infoBlockType = 'ipgpagsegurodireto/payment_info';

  public function __construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  protected function _construct() {
    parent::_construct();
  }

  public function isAvailable($quote = null) {
    $email = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::EMAIL);
    $token = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::TOKEN);

    if (Mage::helper('ipgbase/stringUtils')->isEmpty($email)) {
      $this->logger->fatal('Email ausente na configuração do Módulo PagSeguro Direto.');
      return false;
    }
    if (Mage::helper('ipgbase/stringUtils')->isEmpty($token)) {
      $this->logger->fatal('Token ausente na configuração do Módulo PagSeguro Direto.');
      return false;
    }

    return parent::isAvailable($quote);
  }

  public function getOrderPlaceRedirectUrl() {
    $order = Mage::helper('ipgpagsegurodireto/session')->getCurrentOrder();
    $paymentPost = $this->getPaymentPost();
    $opc = explode("_", $paymentPost['type']);
    
    $paymentType = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($opc[0]);
    $paymentMode = Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf($opc[1]);

    $this->_colocaParametrosNaSessao($paymentType, $paymentMode, $order);

    return Mage::getUrl('ipgpagsegurodireto/payment/pay');
  }

  protected function _colocaParametrosNaSessao(Ipagare_PagSeguroDireto_Domain_PaymentMethodCode $paymentType, Ipagare_IpgPagSeguroDireto_PaymentMode $paymentMode, $order) {
    $sessionCoreMage = Mage::getSingleton('ipgbase/session');
    $sessionCoreMage->setMeioPagamento($paymentType->getValue());
    $sessionCoreMage->setFormaPagamento($paymentMode->getCodigo());
    $sessionCoreMage->setOrderId($order->getRealOrderId());
    $sessionCoreMage->setRealOrderId($order->getRealOrderId());

    $paymentPost = $this->getPaymentPost();

    $sessionCoreMage->setSenderHash($this->getSenderHash($paymentPost));
    $sessionCoreMage->setPagSeguroSessionId($this->getPagSeguroSessionId($paymentPost));
    $sessionCoreMage->setPagSeguroSenderHash($this->getPagSeguroSenderHash($paymentPost));

    $paymentMethod = null;

    if ($paymentType->isCreditCard()) {
      $paymentMethod = 'creditCard';
      $codigoBinCartao = $this->getCodigoBinCartao($paymentPost);
      $numeroCartao = trim($codigoBinCartao . $this->getNumeroCartao($paymentPost));
      $mesValidadeCartao = $this->getMesValidadeCartao($paymentPost);
      $anoValidadeCartao = $this->getAnoValidadeCartao($paymentPost);
      $codigoSegurancaCartao = $this->getCodigoSegurancaCartao($paymentPost);

      $encrypt = Mage::getModel('payment/info');
      $numeroCartao = $encrypt->encrypt($numeroCartao);
      $mesValidadeCartao = $encrypt->encrypt($mesValidadeCartao);
      $anoValidadeCartao = $encrypt->encrypt($anoValidadeCartao);
      $codigoSegurancaCartao = $encrypt->encrypt($codigoSegurancaCartao);

      $sessionCoreMage->setCreditCardToken($this->getCreditCardToken($paymentPost));
      $sessionCoreMage->setNumeroCartao($numeroCartao);
      $sessionCoreMage->setMesValidadeCartao($mesValidadeCartao);
      $sessionCoreMage->setAnoValidadeCartao($anoValidadeCartao);
      $sessionCoreMage->setCodigoSegurancaCartao($codigoSegurancaCartao);
      $sessionCoreMage->setNomePortador($this->getNomePortador($paymentPost));

      $sessionCoreMage->setPagSeguroCreditCardToken($this->getPagSeguroCreditCardToken($paymentPost));
      $sessionCoreMage->setPagSeguroInstallmentQuantity($this->getPagSeguroInstallmentQuantity($paymentPost));
      $sessionCoreMage->setPagSeguroInstallmentValue($this->getPagSeguroInstallmentValue($paymentPost));

      $sessionCoreMage->setCpfPortador($this->getCpfPortador($paymentPost));
      $sessionCoreMage->setDataNascimentoPortador($this->getNascimentoPortador($paymentPost));
      $sessionCoreMage->setAreaCodePortador($this->getAreaCodePortador($paymentPost));
      $sessionCoreMage->setFoneNumberPortador($this->getPhonePortador($paymentPost));
    } else if ($paymentType->isBoleto()) {
      $paymentMethod = 'boleto';
    } else if ($paymentType->isDebitoBancario()) {
      $paymentMethod = 'eft';
    }

    $sessionCoreMage->setPagSeguroPaymentMethod($paymentMethod);
  }

  private function getPaymentPost() {
    return Mage::app()->getRequest()->getPost('payment');
  }

  private function getNumeroCartao($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_numero_cartao"];
  }

  private function getMesValidadeCartao($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_mes_validade_cartao"];
  }

  private function getAnoValidadeCartao($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_ano_validade_cartao"];
  }

  private function getCodigoSegurancaCartao($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_codigo_seguranca_cartao"];
  }

  private function getCreditCardToken($paymentPost) {
    if (isset($paymentPost["ipg_pagsegurodireto_credit_card_token"])) {
      if (!Mage::helper('ipgbase/stringUtils')->isEmpty($paymentPost["ipg_pagsegurodireto_credit_card_token"])) {
        return $paymentPost["ipg_pagsegurodireto_credit_card_token"];
      }
    }
    return '';
  }

  private function getSenderHash($paymentPost) {
    if (isset($paymentPost["ipg_pagsegurodireto_sender_hash"])) {
      if (!Mage::helper('ipgbase/stringUtils')->isEmpty($paymentPost["ipg_pagsegurodireto_sender_hash"])) {
        return $paymentPost["ipg_pagsegurodireto_sender_hash"];
      }
    }
    return '';
  }

  private function getCodigoBinCartao($paymentPost) {
    if (isset($paymentPost["ipgpagsegurodireto_codigo_bin_cartao"])) {
      if (!Mage::helper('ipgbase/stringUtils')->isEmpty($paymentPost["ipgpagsegurodireto_codigo_bin_cartao"])) {
        return $paymentPost["ipgpagsegurodireto_codigo_bin_cartao"];
      }
    }
    return '';
  }

  private function getNomePortador($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_nome_titular_cartao"];
  }

  private function getCpfPortador($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_cpf_titular_cartao"];
  }

  private function getNascimentoPortador($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_nascimento_titular_cartao"];
  }

  private function getAreaCodePortador($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_areacode_titular_cartao"];
  }

  private function getPhonePortador($paymentPost) {
    return $paymentPost["ipgpagsegurodireto_fonenumber_titular_cartao"];
  }

  private function getPagSeguroSessionId($paymentPost) {
    return $paymentPost["ipg_pagsegurodireto_session_id"];
  }

  private function getPagSeguroCreditCardToken($paymentPost) {
    return $paymentPost["ipg_pagsegurodireto_credit_card_token"];
  }

  private function getPagSeguroSenderHash($paymentPost) {
    return $paymentPost["ipg_pagsegurodireto_sender_hash"];
  }

  private function getPagSeguroInstallmentQuantity($paymentPost) {
    return $paymentPost["ipg_pagsegurodireto_installment_quantity"];
  }

  private function getPagSeguroInstallmentValue($paymentPost) {
    return $paymentPost["ipg_pagsegurodireto_installment_value"];
  }

}
