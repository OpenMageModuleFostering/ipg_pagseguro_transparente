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

class Ipagare_IpgPagSeguroDireto_Model_ShopPayment extends Mage_Core_Model_Abstract {

  const TAXA_VALOR_ABSOLUTO = "0";
  const TAXA_VALOR_PERCENTAGEM = "1";
  const ACRESCIMO = "0";
  const DESCONTO = "1";
  // Geral
  const ACTIVE = 'active';
  const VALOR_MINIMO_PEDIDO = 'valor_minimo_pedido';
  const VALOR_MAXIMO_PEDIDO = 'valor_maximo_pedido';
  const VALOR_MINIMO_PARCELA = 'valor_minimo_parcela';
  const JUROS = 'juros';
  const DESCONTO_AVISTA = 'desconto_avista';

  public function getShopPayment($codigoPaymentType) {
    $store = Mage::getSingleton('checkout/session')->getQuote()->getStore();
    $shopPayment = null;
    $codigosCartao = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_CODIGOS, $store));
    $codigosBoleto = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_CODIGOS, $store));
    $codigosDebito = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_CODIGOS, $store));

    $shopPayment = new Ipagare_IpgPagSeguroDireto_ShopPayment();

    // CARTAO
    if (in_array($codigoPaymentType, $codigosCartao)) {
      $shopPayment->setPaymentType(new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($codigoPaymentType));
      $shopPayment->addSetting(self::ACTIVE, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_ACTIVE, $store));
      $shopPayment->addSetting(self::VALOR_MINIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_VALOR_MINIMO, $store)));
      $shopPayment->addSetting(self::VALOR_MAXIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_VALOR_MAXIMO, $store)));
      $shopPayment->addSetting(self::DESCONTO_AVISTA, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_DESCONTO_AVISTA, $store));
    }
    // BOLETO
    if (in_array($codigoPaymentType, $codigosBoleto)) {
      $shopPayment->setPaymentType(new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($codigoPaymentType));
      $shopPayment->addSetting(self::ACTIVE, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_ACTIVE, $store));
      $shopPayment->addSetting(self::VALOR_MINIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_VALOR_MINIMO, $store)));
      $shopPayment->addSetting(self::VALOR_MAXIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_VALOR_MAXIMO, $store)));
      $shopPayment->addSetting(self::DESCONTO_AVISTA, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_DESCONTO_AVISTA, $store));
    }
    // DEBITO
    if (in_array($codigoPaymentType, $codigosDebito)) {
      $shopPayment->setPaymentType(new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($codigoPaymentType));
      $shopPayment->addSetting(self::ACTIVE, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_ACTIVE, $store));
      $shopPayment->addSetting(self::VALOR_MINIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_VALOR_MINIMO, $store)));
      $shopPayment->addSetting(self::VALOR_MAXIMO_PEDIDO, Mage::helper('ipgbase/math')->formatPriceToUS(Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_VALOR_MAXIMO, $store)));
      $shopPayment->addSetting(self::DESCONTO_AVISTA, Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_DESCONTO_AVISTA, $store));
    }

    return $shopPayment;
  }

  public function listActiveShopPayments() {
    $store = Mage::getSingleton('checkout/session')->getQuote()->getStore();
    if (!Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::ACTIVE, $store)) {
      return null;
    }
    $codigosCartao = null;
    $codigosBoleto = null;
    $codigosDebito = null;

    if (Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_ACTIVE, $store)) {
      $codigosCartao = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::CARTAO_CODIGOS, $store));
    }
    if (Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_ACTIVE, $store)) {
      $codigosBoleto = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::BOLETO_CODIGOS, $store));
    }
    if (Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_ACTIVE, $store)) {
      $codigosDebito = explode(',', Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::DEBITO_CODIGOS, $store));
    }

    $codigos = array();
    if (Mage::helper('ipgpagsegurodireto')->notNull($codigosCartao)) {
      $codigos = array_merge($codigos, $codigosCartao);
    }
    if (Mage::helper('ipgpagsegurodireto')->notNull($codigosBoleto)) {
      $codigos = array_merge($codigos, $codigosBoleto);
    }
    if (Mage::helper('ipgpagsegurodireto')->notNull($codigosDebito)) {
      $codigos = array_merge($codigos, $codigosDebito);
    }

    if (Mage::helper('ipgpagsegurodireto')->notNull($codigos)) {
      $shopPayments = array();
      foreach ($codigos as $codigo) {
        $shopPayments[$codigo] = $this->getShopPayment($codigo);
      }
      return $shopPayments;
    }
    return null;
  }

}
