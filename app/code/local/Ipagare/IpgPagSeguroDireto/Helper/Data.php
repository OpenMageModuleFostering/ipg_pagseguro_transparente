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

class Ipagare_IpgPagSeguroDireto_Helper_Data extends Mage_Core_Helper_Abstract {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * Verifica se o módulo está ativo.
   * @return type boolean
   */
  public function isModuleActive() {
    return Mage::getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::ACTIVE);
  }

  public static function buildParametersForLog($parameters) {
    $paramsLog = '';
    foreach ($parameters as $key => $value) {
      $paramsLog .= $key . ' = ' . $value . "\n";
    }
    return $paramsLog;
  }

  public static function formatPriceToUS($value) {
    if (is_null($value)) {
      return null;
    }
    if (!is_string($value)) {
      return floatval($value);
    }

    //trim space and apos
    $value = str_replace('\'', '', $value);
    $value = str_replace(' ', '', $value);

    $separatorComa = strpos($value, ',');
    $separatorDot = strpos($value, '.');

    if ($separatorComa !== false && $separatorDot !== false) {
      if ($separatorComa > $separatorDot) {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
      } else {
        $value = str_replace(',', '', $value);
      }
    } elseif ($separatorComa !== false) {
      $value = str_replace(',', '.', $value);
    }

    return floatval($value);
  }

  /*
   * Converte o valor do formato enviado em centavos para o formato numérico.
   * Exemplo: 49999 para 499.99
   */

  public static function convertStringCentsToDouble($cents) {
    $value = self::formatPriceToUS($cents);
    $value = str_ireplace(".", "", $value);
    return $value / 100;
  }

  public function formatCpf($cpf) {
    $formatCpf = preg_replace("/[^0-9]/", '', $cpf);
    $formatCpf = str_pad($formatCpf, 11, '0', STR_PAD_LEFT);

    return substr($formatCpf, -11);
  }

  public function formatCep($cep) {
    $formatCep = preg_replace("/[^0-9]/", '', $cep);
    $formatCep = str_pad($formatCep, 8, '0', STR_PAD_RIGHT);

    return substr($formatCep, -8);
  }

  public static function notNull($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      }
      return false;
    }
    if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
      return true;
    }
    return false;
  }

  public static function clearSession() {
    Mage::getSingleton('checkout/session')->clear();
    foreach (Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item) {
      Mage::getSingleton('checkout/cart')->removeItem($item->getId())->save();
    }
  }

  public static function formataValorPagSeguro($valor) {
    $valor = Mage::helper('ipgbase/math')->formatPriceToUS($valor);
    $a1 = explode('.', $valor);
    if (sizeof($a1) == 1) {
      $valor = $a1[0] . '.00';
    } else if (strlen($a1[1]) == 1) {
      $valor = $a1[0] . '.' . $a1[1] . '0';
    }
    return $valor;
  }

  public function getPagSeguroLibrary() {
    $ds = DIRECTORY_SEPARATOR;
    $basePath = Mage::getBaseDir('lib');
    require_once $basePath . $ds . 'Ipagare' . $ds . 'PagSeguroDireto' . $ds . 'Library.php';
  }

}
