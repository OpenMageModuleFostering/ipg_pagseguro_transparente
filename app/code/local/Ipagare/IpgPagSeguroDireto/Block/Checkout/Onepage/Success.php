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

class Ipagare_IpgPagSeguroDireto_Block_Checkout_Onepage_Success extends Mage_Checkout_Block_Onepage_Success {

  public function getViewOrder() {
    return (bool) Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::PAGINA_SUCESSO_MOSTRAR_CONTEUDO) || (bool) $this->_getData('can_view_order');
  }

  public function getCanViewOrder() {
    return (bool) Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::PAGINA_SUCESSO_MOSTRAR_CONTEUDO) || (bool) $this->_getData('can_view_order');
  }

  public function getCanPrintOrder() {
    return (bool) Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::PAGINA_SUCESSO_MOSTRAR_CONTEUDO) || (bool) $this->_getData('can_print_order');
  }

  public function getLastOrder() {
    return Mage::helper('ipgpagsegurodireto/session')->getCurrentOrder();
  }

  public function getPaymentData() {
    return Mage::getSingleton('ipgbase/session')->getPaymentData();
  }

}
