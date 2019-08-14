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

class Ipagare_IpgBase_Block_Adminhtml_System_Config_Fieldset_Licenca extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface {

    /**
     * Render element html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $stringExp = '';
        if (extension_loaded('ionCube Loader')) {
            $ioncubeInfo = ioncube_file_info();
            if (isset($ioncubeInfo['FILE_EXPIRY'])) {
                $dataExpiracao = date('d/m/Y', $ioncubeInfo['FILE_EXPIRY']);
                $stringExp = '<h6>Sua licença expira em ' . $dataExpiracao . '. Para renovar sua licença, entre em contato com nosso <a href="http://ajuda.ipagare.com.br/" target="_blank">suporte.</a></h6><br/>';
            }
        }
        return sprintf($stringExp);
    }
}