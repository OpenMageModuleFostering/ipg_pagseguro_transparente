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

class Ipagare_IpgPagSeguroDireto_Model_Credential extends Mage_Core_Model_Abstract {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * 
   * 
   * @return String
   */
  public function getAccountCredentials() {
    $email = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::EMAIL);
    $token = Mage::helper('ipgbase')->getStoreConfig(Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem::TOKEN);

    return new Ipagare_PagSeguroDireto_Domain_AccountCredentials($email, $token);
  }

  /**
   * Autentica no PagSeguro e retorna o ID da Sessão.
   * 
   * @return String
   */
  public function getSessionId() {
    $credentials = $this->getAccountCredentials();
    $sessionResponse = Ipagare_PagSeguroDireto_Service_SessionService::createSession($credentials);
    if ($sessionResponse->hasErrors()) {
      foreach ($sessionResponse->getErrors() as $error) {
        $this->logger->error('(' . $error->getCode() . ') ' . $error->getMessage());
      }
    }

    return $sessionResponse;
  }

}
