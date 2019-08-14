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

class Ipagare_IpgPagSeguroDireto_Helper_Math extends Mage_Core_Helper_Abstract {

  /**
   * Calcula valor da parcela para financiamento em parcelas fixas.
   * 
   * @param total
   *            Valor total financiado
   * @param interestRate
   *            Taxa de juros
   * @param numberOfPayments
   *            Número de parcelas
   * @return valor da parcela
   */
  public static function calculatePayment($total, $interestRate, $numberOfPayments) {
    $payment = 0;
    if ($interestRate != 0) {
      if (self::isJuroComposto()) {
        // Calculo do valor da parcela - Juros Composto { M = (C. (1 + i)t) / t }
        $total_parcela = round(($total * pow((1 + $interestRate), $numberOfPayments)) / $numberOfPayments, 2);
        $payment = round($total_parcela, 2);
      } else {
        // Calculo do valor da parcela - Tabela Price { R = P x [ i (1 + i)n ] ÷ [ (1 + i )n -1] }
        $payment = round($total * (($interestRate * pow((1 + $interestRate), $numberOfPayments)) / (pow((1 + $interestRate), $numberOfPayments) - 1)), 2);
      }
    } else {
      $payment = $total / $numberOfPayments;
    }

    return $payment;
  }

  /*
   * Converte o valor do formato enviado em centavos para o formato numérico.
   * Exemplo: 49999 para 499.99
   */

  public static function convertStringCentsToDouble($cents) {
    $value = Mage::helper('ipgbase/math')->formatPriceToUS($cents);
    $value = str_ireplace(".", "", $value);
    return $value / 100;
  }

  /**
   * Formata um valor para ter no máximo dois dígitos após a vírgula.
   */
  public static function formatAmount($amount) {
    return round($amount, 2);
  }

  /**
   * Recebe um numérico e retorna o mesmo valor em centavos.
   * Entrada: 12,34, saída 1234
   */
  public static function formatPaymentAmountToCents($amount) {
    $amountInt = (int) $amount;
    if ($amountInt == $amount) {
      $amount = (int) $amount;
      //transforma em string
      $amountStr = $amount;
      $amountStr = str_ireplace(",", "", $amountStr);
      $amountStr = str_ireplace(".", "", $amountStr);
      //adiciona os zeros dos centavos.
      $amountStr = $amountStr . '00';
    } else {
      $amount = self::formatAmount($amount);
      $amountStr = $amount;

      $pos = strpos($amountStr, '.');
      $decimais = substr($amountStr, $pos + 1);
      $tamDecimais = strlen($decimais);

      while ($tamDecimais < 2) {
        $amountStr = $amountStr . '0';

        $pos = strpos($amountStr, '.');
        $decimais = substr($amountStr, $pos + 1);
        $tamDecimais = strlen($decimais);
      }

      $amountStr = str_ireplace(",", "", $amountStr);
      $amountStr = str_ireplace(".", "", $amountStr);
    }

    return $amountStr;
  }

}
