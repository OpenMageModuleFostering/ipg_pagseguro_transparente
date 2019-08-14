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

class Ipagare_IpgBase_Helper_StringUtils extends Mage_Core_Helper_Abstract {

    /**
     * Verifica se determinada valor é <strong>null</strong> ou <strong>vazio</strong>.
     * 
     * @param type $str
     * @return type
     */
    public static function isEmpty($str) {
        if ($str == null) {
            return true;
        }
        if (trim($str) == '') {
            return true;
        }
        return false;
    }

    public static function removeParentheses($str) {
        if (self::isEmpty($str)) {
            return $str;
        }
        $str = str_ireplace('(', '', $str);
        $str = str_ireplace(')', '', $str);
        return $str;
    }
}