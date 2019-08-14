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
 * Encapsulates web service calls regarding Ipagare_PagSeguroDireto_ payment requests
 */
class Ipagare_PagSeguroDireto_Service_PaymentService {

  /**
   *
   */
  const SERVICE_NAME = 'paymentService';

  private $logger;

  public function __construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  /**
   * @param Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData
   * @return string
   */
  private function buildCheckoutRequestUrl(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData) {
    return $connectionData->getServiceUrl() . '/?' . $connectionData->getCredentialsUrlQuery();
  }

  /**
   * 
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param Ipagare_PagSeguroDireto_Domain_PaymentRequest $paymentRequest
   * @return Ipagare_PagSeguroDireto_Domain_PaymentResponse
   */
  public function createTransaction(
  Ipagare_PagSeguroDireto_Domain_Credentials $credentials, Ipagare_PagSeguroDireto_Domain_PaymentRequest $paymentRequest) {
    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);

    try {
      $data = Ipagare_PagSeguroDireto_Parser_PaymentParser::getData($paymentRequest);

      $paymentResponse = Ipagare_PagSeguroDireto_Domain_PaymentResponse::getInstance();
      $paymentResponse->setDataSend($data);

      $this->logger->info('Parametros enviados[PAGAMENTO]: ' . Mage::helper('ipgpagsegurodireto')->buildParametersForLog($data));

      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->post(
          $this->buildCheckoutRequestUrl($connectionData), $data, $connectionData->getServiceTimeout(), $connectionData->getCharset()
      );
      $this->logger->info('Parametros recebidos[PAGAMENTO]: ' . $connection->getResponse());

      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());
      switch ($httpStatus->getType()) {
        case 'OK':
          //$this->logger->info('Parametros recebidos[PAGAMENTO]: ' . $connection->getResponse());
          $paymentParserData = Ipagare_PagSeguroDireto_Parser_PaymentParser::readSuccessXml($connection->getResponse());
          $paymentResponse->setPaymentParserData($paymentParserData);
          break;

        case 'BAD_REQUEST':
          $errors = Ipagare_PagSeguroDireto_Parser_PaymentParser::readErrors($connection->getResponse());
          $paymentResponse->setErrors($errors);
          break;

        default:
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus);
          $paymentResponse->addFatalError($e->getOneLineMessage());
          break;
      }
    } catch (Ipagare_PagSeguroDireto_Exception_ServiceException $e) {
      
    } catch (Exception $e) {
      
    }

    return $paymentResponse;
  }

}
