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

final class Ipagare_IpgBase_Helper_Module extends Mage_Core_Helper_Abstract {

    /**
     * Verifica se o módulo Core existe.
     * 
     * @return type
     */
    public static function isCoreExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgCore_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Cielo existe.
     * 
     * @return type
     */
    public static function isCieloExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgCielo_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Boleto existe.
     * 
     * @return type
     */
    public static function isBoletoExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgBoleto_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo ClearSale existe.
     * 
     * @return type
     */
    public static function isClearSaleExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgClearSale_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Redecard existe.
     * 
     * @return type
     */
    public static function isRedecardExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgRedecard_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Amex existe.
     *
     * @return type
     */
    public static function isAmexExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgAmex_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Itau ShoLine existe.
     *
     * @return type
     */
    public static function isItauShoplineExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgItauShopline_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Bradesco existe.
     *
     * @return type
     */
    public static function isBradescoExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgBradesco_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Branco Brasil existe.
     *
     * @return type
     */
    public static function isBancoBrasilExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgBancoBrasil_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo ClearSale existe.
     * 
     * @return type
     */
    public static function isClearSaleWebServiceExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgClearSaleWebService_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Televendas existe.
     * 
     * @return type
     */
    public static function isTeleVendasExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgTeleVendas_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Moip existe.
     * 
     * @return type
     */
    public static function isMoipExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgMoip_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Pagamento Digital existe.
     * 
     * @return type
     */
    public static function isPagamentoDigitalExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgPagamentoDigital_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo PagSeguro existe.
     * 
     * @return type
     */
    public static function isPagSeguroExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgPagSeguro_Helper_Module');
        error_reporting(1);

        return $exists;
    }
    /**
     * Verifica se o módulo PagSeguro Lightbox existe.
     * 
     * @return type
     */
    public static function isPagSeguroLightboxExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgPagSeguroLightbox_Helper_Module');
        error_reporting(1);

        return $exists;
    }
    
    /**
     * Verifica se o módulo PagSeguro Direto existe.
     * 
     * @return type
     */
    public static function isPagSeguroDiretoExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgPagSeguroDireto_Helper_Module');
        error_reporting(1);

        return $exists;
    }
    
    /**
     * Verifica se o módulo CobreBemAprovaFacil existe.
     * 
     * @return type
     */
    public static function isCobreBemAprovaFacilExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgCobreBemAprovaFacil_Helper_Module');
        error_reporting(1);

        return $exists;
    }
    
     /**
     * Verifica se o módulo ClearSale existe.
     * 
     * @return type
     */
    public static function isClearSaleStartExists() {
        error_reporting(0);
        $exists = class_exists('Ipagare_IpgClearSaleStart_Helper_Module');
        error_reporting(1);

        return $exists;
    }

    /**
     * Verifica se o módulo Boleto existe e está ativo.
     * 
     * @return type
     */
    public function isBoletoExistsAndActive() {
        return $this->isBoletoExists() && Mage::helper('ipgboleto')->isModuleActive();
    }

    /**
     * Verifica se o módulo Cielo existe e está ativo.
     * 
     * @return type
     */
    public function isCieloExistsAndActive() {
        return $this->isCieloExists() && Mage::helper('ipgcielo')->isModuleActive();
    }

    /**
     * Verifica se o módulo ClearSale existe e está ativo.
     * 
     * @return type
     */
    public function isClearSaleExistsAndActive() {
        return $this->isClearSaleExists() && Mage::helper('ipgclearsale')->isModuleActive();
    }

    /**
     * Verifica se o módulo Redecard existe e está ativo.
     * 
     * @return type
     */
    public function isRedecardExistsAndActive() {
        return $this->isRedecardExists() && Mage::helper('ipgredecard')->isModuleActive();
    }

    /**
     * Verifica se o módulo Amex existe e está ativo.
     *
     * @return type
     */
    public function isAmexExistsAndActive() {
        return $this->isAmexExists() && Mage::helper('ipgamex')->isModuleActive();
    }

    /**
     * Verifica se o módulo Itau ShoLine existe e está ativo.
     *
     * @return type
     */
    public function isItauShoplineExistsAndActive() {
        return $this->isItauShoplineExists() && Mage::helper('ipgitaushopline')->isModuleActive();
    }

    /**
     * Verifica se o módulo Bradesco existe e está ativo.
     *
     * @return type
     */
    public function isBradescoExistsAndActive() {
        return $this->isBradescoExists() && Mage::helper('ipgbradesco')->isModuleActive();
    }

    /**
     * Verifica se o módulo Branco Brasil existe e está ativo.
     *
     * @return type
     */
    public function isBancoBrasilExistsAndActive() {
        return $this->isBancoBrasilExists() && Mage::helper('ipgbancobrasil')->isModuleActive();
    }

    /**
     * Verifica se o módulo ClearSaleWebService existe e está ativo.
     * 
     * @return type
     */
    public function isClearSaleWebServiceExistsAndActive() {
        return $this->isClearSaleWebServiceExists() && Mage::helper('ipgclearsalewebservice')->isModuleActive();
    }

    /**
     * Verifica se o módulo Moip existe e está ativo.
     * 
     * @return type
     */
    public function isMoipExistsAndActive() {
        return $this->isMoipExists() && Mage::helper('ipgmoip')->isModuleActive();
    }
    
    /**
     * Verifica se o módulo Pagamento Digital existe e está ativo.
     * 
     * @return type
     */
    public function isPagamentoDigitalExistsAndActive() {
        return $this->isPagamentoDigitalExists() && Mage::helper('ipgpagamentodigital')->isModuleActive();
    }

    /**
     * Verifica se o módulo PagSeguro existe e está ativo.
     * 
     * @return type
     */
    public function isPagSeguroExistsAndActive() {
        return $this->isPagSeguroExists() && Mage::helper('ipgpagseguro')->isModuleActive();
    }
    /**
     * Verifica se o módulo PagSeguro Lightbox existe e está ativo.
     * 
     * @return type
     */
    public function isPagSeguroLightboxExistsAndActive() {
        return $this->isPagSeguroLightboxExists() && Mage::helper('ipgpagsegurolightbox')->isModuleActive();
    }
    
    /**
     * Verifica se o módulo PagSeguro Direto existe e está ativo.
     * 
     * @return type
     */
    public function isPagSeguroDiretoExistsAndActive() {
        return $this->isPagSeguroDiretoExists() && Mage::helper('ipgpagsegurodireto')->isModuleActive();
    }
    
    
    /**
     * Verifica se o módulo Pagamento Digital existe e está ativo.
     * 
     * @return type
     */
    public function isCobreBemAprovaFacilExistsAndActive() {
        return $this->isCobreBemAprovaFacilExists() && Mage::helper('ipgcobrebemaprovafacil')->isModuleActive();
    }

    
     /**
     * Verifica se o módulo ClearSale Start existe e está ativo.
     * 
     * @return type
     */
    public function isClearSaleStartExistsAndActive() {
        return $this->isClearSaleStartExists() && Mage::helper('ipgclearsalestart')->isModuleActive();
    }
}