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

class Ipagare_IpgBase_Block_Adminhtml_System_Config_Form_Field_NeedHelp extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface {

    /**
     * Render element html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $imgHelp = $this->getSkinUrl('ipgbase/images/help.png');
        return sprintf('<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5"><h6 style="background-color: #FFF8E9;padding: 5px" id="%s"><img src=' . $imgHelp . '></img>%s</h6></td></tr>', $element->getHtmlId(), $element->getHtmlId(), $element->getLabel()
        );
    }
}