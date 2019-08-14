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

class Ipagare_IpgPagSeguroDireto_Model_Sales_Order_Invoice_Total_Discount extends Mage_Sales_Model_Order_Invoice_Total_Abstract {

  protected $_code = 'discount-ipgpagsegurodireto';

  public function collect(Mage_Sales_Model_Order_Invoice $invoice) {
    parent::collect($invoice);
    $order = $invoice->getOrder();
    $baseTotalDiscountAmount = $order->getIpgPagsegurodiretoBaseDiscountAmount();
    $totalDiscountAmount = Mage::app()->getStore()->convertPrice($baseTotalDiscountAmount);

    $invoice->setIpgPagsegurodiretoDiscountAmount($totalDiscountAmount);
    $invoice->setIpgPagsegurodiretoBaseDiscountAmount($baseTotalDiscountAmount);

    $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getIpgPagsegurodiretoDiscountAmount());
    $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getIpgPagsegurodiretoBaseDiscountAmount());

    return $this;
  }

}
