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

class Ipagare_IpgPagSeguroDireto_Model_PaymentType extends Mage_Core_Model_Abstract {

  private $paymentMathModel;
  private $shopPaymentModel;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->paymentMathModel = Mage::getModel('ipgpagsegurodireto/paymentMath');
    $this->shopPaymentModel = Mage::getModel('ipgpagsegurodireto/shopPayment');
  }

  /**
   * Retorna todas as opções de pagamento disponíveis para o pedido.
   * 
   * @param type $total
   */
  public function getPaymentTypeOptions($total) {
    $shopPayments = $this->shopPaymentModel->listActiveShopPayments();
    return $this->buildPaymentTypeOptions($shopPayments, $total);
  }

  private function buildPaymentTypeOptions($shopPayments, $total) {
    $paymentTypeOptions = new Ipagare_IpgPagSeguroDireto_PaymentTypeOptions();
    if (!is_null($shopPayments) && count($shopPayments) > 0) {
      foreach ($shopPayments as $key => $shopPayment) {
        $paymentTypeOption = $this->buildPaymentTypeOption($shopPayment, $total);
        if (!is_null($paymentTypeOption)) {
          $paymentTypeOptions->addOption($paymentTypeOption);
        }
      }
      if (!$paymentTypeOptions->hasOptions()) {
        $paymentTypeOptions->addError(Ipagare_IpgPagSeguroDireto_Config::ERROR_002);
      }
    } else {
      $paymentTypeOptions->addError(Ipagare_IpgPagSeguroDireto_Config::ERROR_001);
    }

    return $paymentTypeOptions;
  }

  private function buildPaymentTypeOption(Ipagare_IpgPagSeguroDireto_ShopPayment $shopPayment, $total) {
    $paymentTypeOption = null;
    $maximumOrderValue = $shopPayment->getSetting(Ipagare_IpgPagSeguroDireto_Model_ShopPayment::VALOR_MAXIMO_PEDIDO);

    if ($this->isLessThanMaximumOrderValue($total, $maximumOrderValue)) {
      $paymentModeOptions = $this->getPaymentModeOptions($total, $shopPayment);
      if (!is_null($paymentModeOptions) && count($paymentModeOptions) > 0) {
        $paymentType = $shopPayment->getPaymentType();

        $paymentTypeOption = new Ipagare_IpgPagSeguroDireto_PaymentTypeOption();
        $paymentTypeOption->setPaymentType($paymentType);
        $paymentTypeOption->setPaymentModes($paymentModeOptions);
      }
    }

    return $paymentTypeOption;
  }

  /**
   * 
   * Verifica se o valor do pedido é menor ou igual que o valor máximo
   * 
   * @param orderValue
   * @param maximum
   * @return
   */
  private function isLessThanMaximumOrderValue($orderValue, $maximumOrderValue) {
    $less = true;
    $maximum = 0;
    if (!Mage::helper('ipgbase/stringUtils')->isEmpty($maximumOrderValue)) {
      $maximum = $maximumOrderValue;
      if ($orderValue > $maximum) {
        $less = false;
      }
    }

    return $less;
  }

  /**
   * 
   * Verifica se o valor do pedido é maior ou igual que o valor minimo
   * 
   * @param orderValue
   * @param minimumOrderValue
   * @return
   */
  private function isGreaterThanMinimumOrderValue($orderValue, $minimumOrderValue) {
    $greater = true;
    if ($orderValue < $minimumOrderValue) {
      $greater = false;
    }

    return $greater;
  }

  private function getPaymentModeOptions($total, $shopPayment) {
    if (is_null($shopPayment)) {
      return null;
    }
    $paymentModeOptions = array();
    $paymentType = $shopPayment->getPaymentType();

    $taxaPagamento = null;
    $taxaAbsolutoPercentagem = null;
    $taxaDesconto = null;

    $descontoAvista = str_replace(',', '.', $this->paymentMathModel->getDescontoAvista($paymentType));
    $valorMinimoParcela = str_replace(',', '.', $this->paymentMathModel->getParameterValue($paymentType, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::VALOR_MINIMO_PARCELA));
    $juros = str_replace(',', '.', $this->paymentMathModel->getParameterValue($paymentType, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::JUROS));

    $newOrderTotal = $this->addTax($total, $taxaPagamento, $taxaAbsolutoPercentagem, $taxaDesconto);

    $minimumOrderValue = $shopPayment->getSetting(Ipagare_IpgPagSeguroDireto_Model_ShopPayment::VALOR_MINIMO_PEDIDO);
    if ($this->isGreaterThanMinimumOrderValue($newOrderTotal, $minimumOrderValue)) {
      if ($paymentType->isCreditCard()) {
        $parcelasTotal = 1;
        $parcelasSemJuros = 1;
        $parcelasTotal = 1;
        $parcelasSemJuros = 1;
        $paymentModes = null;
        $acabou = false;
        $j = 1;
        while (!$acabou) {
          $paymentMode = null;
          $valorParcela = 0;
          if ($j == 1 && !is_null($descontoAvista)) {
            $paymentMode = Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf(Ipagare_IpgPagSeguroDireto_PaymentMode::A01);
            $valorParcela = $this->addTax($newOrderTotal, $descontoAvista, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::TAXA_VALOR_PERCENTAGEM, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::DESCONTO);
            $paymentModeOptions[] = new Ipagare_IpgPagSeguroDireto_PaymentModeOption($paymentMode, $valorParcela, $juros, $descontoAvista, $total);
          }
          $acabou = true;
          $j++;
        }
      } else {
        $newOrderTotal = $this->addTax($newOrderTotal, $descontoAvista, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::TAXA_VALOR_PERCENTAGEM, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::DESCONTO);
        $paymentModeOptions[] = new Ipagare_IpgPagSeguroDireto_PaymentModeOption(Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf(Ipagare_IpgPagSeguroDireto_PaymentMode::A01), $newOrderTotal, 0, $descontoAvista, $total);
      }
    }

    return $paymentModeOptions;
  }

  /**
   * 
   * Adiciona ao valor do pagamento a taxa configurada pelo Estabelecimento
   * 
   * @param paymentAmount
   * @param taxaPagamento
   * @param taxaAbsolutoPercentagem
   * @return
   */
  private function addTax($paymentAmount, $taxaPagamento, $taxaAbsolutoPercentagem, $taxaDesconto) {
    $sessionQuote = Mage::getSingleton('checkout/session')->getQuote();
    $baseShippingAmount = $sessionQuote->getShippingAddress()->getBaseShippingAmount();
    if (is_null($taxaAbsolutoPercentagem)) {
      return $paymentAmount;
    }
    $tax = 0;
    if (!is_null($taxaPagamento)) {
      $tax = $taxaPagamento;
    }
    if (trim($taxaAbsolutoPercentagem) == Ipagare_IpgPagSeguroDireto_Model_ShopPayment::TAXA_VALOR_ABSOLUTO) {
      if (Ipagare_IpgPagSeguroDireto_ShopPayment::DESCONTO == $taxaDesconto) {
        $paymentAmount -= $tax;
      } else {
        $paymentAmount += $tax;
      }
    } else if (trim($taxaAbsolutoPercentagem) == Ipagare_IpgPagSeguroDireto_Model_ShopPayment::TAXA_VALOR_PERCENTAGEM) {
      if (Ipagare_IpgPagSeguroDireto_Model_ShopPayment::DESCONTO == $taxaDesconto) {
        $paymentAmount -= (($paymentAmount - $baseShippingAmount) * $tax) / 100;
      } else {
        $paymentAmount += ($paymentAmount * $tax) / 100;
      }
    }

    return $paymentAmount;
  }

  public function getPaymentAmount($paymentAmount, $meioPagamento, $formaPagamento) {
    $paymentType = new Ipagare_PagSeguroDireto_Domain_PaymentMethodCode($meioPagamento);
    $paymentMode = Ipagare_IpgPagSeguroDireto_PaymentMode::valueOf($formaPagamento);

    $taxaPagamento = null;
    $taxaAbsolutoPercentagem = null;
    $taxaDesconto = null;
    $paymentAmount = $this->addTax($paymentAmount, $taxaPagamento, $taxaAbsolutoPercentagem, $taxaDesconto);

    if ($paymentMode->hasJuros()) {
      $juros = str_replace(',', '.', $this->paymentMathModel->getParameterValue($paymentType, Ipagare_IpgPagSeguroDireto_Model_ShopPayment::JUROS));
      $paymentAmount = $this->calculateTotalValue($paymentAmount, $juros / 100, $paymentMode->getParcelas());
    }
    return Zend_Locale_Math::round($paymentAmount, 2);
  }

  private function calculateTotalValue($total, $interestRate, $numberOfPayments) {
    $payment = 0;
    $valor = $total;
    if ($interestRate != 0) {
      $payment = Mage::helper('ipgpagsegurodireto/math')->calculatePayment($total, $interestRate, $numberOfPayments);
      $valor = $payment * $numberOfPayments;
    }
    return $valor;
  }

}
