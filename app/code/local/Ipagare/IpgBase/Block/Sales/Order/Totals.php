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

class Ipagare_IpgBase_Block_Sales_Order_Totals extends Mage_Sales_Block_Order_Totals {

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals() {
        parent::_initTotals();
        $order = $this->getOrder();
        $payment = $order->getPayment();
        $paymentMethodCode = $payment->getMethodInstance()->getCode();
        
        if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethodCode)) {
            $amount = Mage::getModel($paymentMethodCode . '/discount')->getIpgDiscount($order);
            if (abs($amount) > 0) {
                $baseAmount = Mage::getModel($paymentMethodCode . '/discount')->getIpgBaseDiscount($order);
                $code = Mage::getModel($paymentMethodCode . '/discount')->getIpgDiscountCode();
                $this->addTotal(new Varien_Object(array(
                            'code' => $code,
                            'value' => $amount,
                            'base_value' => $baseAmount,
                            'label' => Mage::helper($paymentMethodCode)->__('Payment Discount'),
                        )));
            }
        }
        return $this;
    }

}