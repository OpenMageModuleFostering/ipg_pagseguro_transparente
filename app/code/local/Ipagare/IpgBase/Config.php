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

final class Ipagare_IpgBase_Config {

    /**
     * Códigos dos meios de pagamento implementados pelo iPAGARE.
     * 
     */
    protected static $_paymentMethods = array('ipgcore', 'ipgmoip', 'ipgpagamentodigital', 'ipgpagseguro', 'ipgcobrebemaprovafacil', 'ipgpagsegurolightbox', 'ipgpagsegurodireto');
    
    /**
     * Identifica que a origem do pedido, tabela "sales_flat_order", campo "ipagare_order_orig" é "televendas".
     */
    const ORDER_ORIG_TELEVENDAS = 'televendas';
    
    /**
     * Retorna a lista com os métodos de pagamentos
     * 
     * @return type array
     */
    public static function listPaymentMethods() {
        return self::$_paymentMethods;
    }

}