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

class Ipagare_IpgBase_Block_Adminhtml_System_Config_Form_Field_Date extends Mage_Adminhtml_Block_System_Config_Form_Field {

    public function render(Varien_Data_Form_Element_Abstract $element) {
        //$element->setFormat(Varien_Date::DATE_INTERNAL_FORMAT); //or other format
        $element->setFormat('dd/MM/yyyy'); //or other format
        $element->setImage($this->getSkinUrl('images/grid-cal.gif'));
        return parent::render($element);
    }

}

?>
