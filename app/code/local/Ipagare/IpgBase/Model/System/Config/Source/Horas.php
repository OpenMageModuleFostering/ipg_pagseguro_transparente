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

class Ipagare_IpgBase_Model_System_Config_Source_Horas {

    public function toOptionArray() {
        $opcoes = array();
        for ($i = 0; $i <= 23; $i++) {
            $hora = str_pad($i, 2, '0', STR_PAD_LEFT);
            $opcoes[$hora] = $hora;
        }
        return $opcoes;
    }

}