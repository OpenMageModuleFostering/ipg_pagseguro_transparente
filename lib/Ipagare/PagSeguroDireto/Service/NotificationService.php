<?php

/*
 * ***********************************************************************
  Copyright [2011] [Ipagare_PagSeguroDireto_ Internet Ltda.]

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 * ***********************************************************************
 */

/**
 * Encapsulates web service calls regarding Ipagare_PagSeguroDireto_ notifications
 */
class Ipagare_PagSeguroDireto_Service_NotificationService {

  /**
   *
   */
  const SERVICE_NAME = 'notificationService';

  private $logger;

  public function __construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * @param Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData
   * @param $notificationCode
   * @return string
   */
  private function buildTransactionNotificationUrl(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData, $notificationCode) {
    $url = $connectionData->getServiceUrl();
    return "{$url}/{$notificationCode}/?" . $connectionData->getCredentialsUrlQuery();
  }

  /**
   * Returns a transaction from a notification code
   *
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param String $notificationCode
   * @throws Ipagare_PagSeguroDireto_Exception_ServiceException
   * @throws Exception
   * @return Ipagare_PagSeguroDireto_Domain_Transaction
   * @see Ipagare_PagSeguroDireto_Domain_Transaction
   */
  public function checkTransaction(Ipagare_PagSeguroDireto_Domain_Credentials $credentials, $notificationCode) {
    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);

    $transactionSearchResponse = Ipagare_PagSeguroDireto_Domain_TransactionSearchResponse::getInstance();

    $this->logger->info('Parametros enviados[NOTIFICATION]: ' . $notificationCode);

    try {
      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->get(
          self::buildTransactionNotificationUrl($connectionData, $notificationCode), $connectionData->getServiceTimeout(), $connectionData->getCharset()
      );

      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());

      switch ($httpStatus->getType()) {
        case 'OK':
          $this->logger->info('Parametros recebidos[NOTIFICATION]: ' . $connection->getResponse());
          $transaction = Ipagare_PagSeguroDireto_Parser_TransactionParser::readTransaction($connection->getResponse());
          $transactionSearchResponse->setTransaction($transaction);
          break;

        case 'BAD_REQUEST':
          $errors = Ipagare_PagSeguroDireto_Parser_TransactionParser::readErrors($connection->getResponse());
          $transactionSearchResponse->setErrors($errors);
          break;

        default:
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus);
          $transactionSearchResponse->setErrors(array(new Ipagare_PagSeguroDireto_Domain_Error('99999', $e->getFormattedMessage())));
          break;
      }
    } catch (Ipagare_PagSeguroDireto_Exception_ServiceException $e) {
      
    } catch (Exception $e) {
      
    }

    return $transactionSearchResponse;
  }

}
