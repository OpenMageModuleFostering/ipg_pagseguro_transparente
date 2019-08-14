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
 * Encapsulates web service calls to search for Ipagare_PagSeguroDireto_ transactions
 */
class Ipagare_PagSeguroDireto_Service_TransactionSearchService {

  const SERVICE_NAME = 'transactionSearchService';

  private $logger;

  public function __construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  private function buildSearchUrlByCode(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData, $transactionCode) {
    $url = $connectionData->getServiceUrl();
    return "{$url}/{$transactionCode}/?" . $connectionData->getCredentialsUrlQuery();
  }

  private function buildSearchUrlByDate(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData, array $searchParams) {
    $url = $connectionData->getServiceUrl();
    $initialDate = $searchParams['initialDate'] != null ? $searchParams['initialDate'] : "";
    $finalDate = $searchParams['finalDate'] != null ? ("&finalDate=" . $searchParams['finalDate']) : "";
    if ($searchParams['pageNumber'] != null) {
      $page = "&page=" . $searchParams['pageNumber'];
    }
    if ($searchParams['maxPageResults'] != null) {
      $maxPageResults = "&maxPageResults=" . $searchParams['maxPageResults'];
    }
    return "{$url}/?" . $connectionData->getCredentialsUrlQuery() .
        "&initialDate={$initialDate}{$finalDate}{$page}{$maxPageResults}";
  }

  private function buildSearchUrlAbandoned(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData, array $searchParams) {
    $url = $connectionData->getServiceUrl();
    $initialDate = $searchParams['initialDate'] != null ? $searchParams['initialDate'] : "";
    $finalDate = $searchParams['finalDate'] != null ? ("&finalDate=" . $searchParams['finalDate']) : "";
    if ($searchParams['pageNumber'] != null) {
      $page = "&page=" . $searchParams['pageNumber'];
    }
    if ($searchParams['maxPageResults'] != null) {
      $maxPageResults = "&maxPageResults=" . $searchParams['maxPageResults'];
    }
    return "{$url}/abandoned/?" . $connectionData->getCredentialsUrlQuery() .
        "&initialDate={$initialDate}&finalDate={$finalDate}{$page}{$maxPageResults}";
  }

  /**
   * Finds a transaction with a matching transaction code
   *
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param String $transactionCode
   * @return Ipagare_PagSeguroDireto_Domain_Transaction a transaction object
   * @see Ipagare_PagSeguroDireto_Domain_TransactionSearchResponse
   * @throws Ipagare_PagSeguroDireto_Exception_ServiceException
   * @throws Exception
   */
  public function searchByCode(Ipagare_PagSeguroDireto_Domain_Credentials $credentials, $transactionCode) {
    $this->logger->info('Parametros enviados[TRANSACTION]: ' . $transactionCode);

    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);

    $transactionSearchResponse = Ipagare_PagSeguroDireto_Domain_TransactionSearchResponse::getInstance();

    try {
      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->get(
          $this->buildSearchUrlByCode($connectionData, $transactionCode), $connectionData->getServiceTimeout(), $connectionData->getCharset()
      );
      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());

      switch ($httpStatus->getType()) {
        case 'OK':
          $this->logger->info('Parametros recebidos[TRANSACTION]: ' . $connection->getResponse());
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

  /**
   * Search transactions associated with this set of credentials within a date range
   *
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param integer $pageNumber
   * @param integer $maxPageResults
   * @param String $initialDate
   * @param String $finalDate
   * @return a object of Ipagare_PagSeguroDireto_TransactionSerachResult class
   * @see Ipagare_PagSeguroDireto_Domain_TransactionSearchResult
   * @throws Ipagare_PagSeguroDireto_Exception_ServiceException
   * @throws Exception
   */
  public function searchByDate(
  Ipagare_PagSeguroDireto_Domain_Credentials $credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate = null
  ) {
    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);

    $searchParams = array(
        'initialDate' => Ipagare_PagSeguroDireto_Helper_Helper::formatDate($initialDate),
        'pageNumber' => $pageNumber,
        'maxPageResults' => $maxPageResults
    );

    $searchParams['finalDate'] = $finalDate ? Ipagare_PagSeguroDireto_Helper_Helper::formatDate($finalDate) : null;

    try {
      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->get(
          $this->buildSearchUrlByDate($connectionData, $searchParams), $connectionData->getServiceTimeout(), $connectionData->getCharset()
      );

      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());

      switch ($httpStatus->getType()) {

        case 'OK':
          $searchResult = Ipagare_PagSeguroDireto_Parser_TransactionParser::readSearchResult($connection->getResponse());
          break;

        case 'BAD_REQUEST':
          $errors = Ipagare_PagSeguroDireto_Parser_TransactionParser::readErrors($connection->getResponse());
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus, $errors);
          throw $e;
          break;

        default:
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus);
          throw $e;
          break;
      }

      return isset($searchResult) ? $searchResult : false;
    } catch (Ipagare_PagSeguroDireto_Exception_ServiceException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Search transactions abandoned associated with this set of credentials within a date range
   *
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param String $initialDate
   * @param String $finalDate
   * @param integer $pageNumber
   * @param integer $maxPageResults
   * @return Ipagare_PagSeguroDireto_Domain_TransactionSearchResult a object of Ipagare_PagSeguroDireto_Domain_TransactionSearchResult class
   * @see Ipagare_PagSeguroDireto_Domain_TransactionSearchResult
   * @throws Ipagare_PagSeguroDireto_Exception_ServiceException
   * @throws Exception
   */
  public function searchAbandoned(
  Ipagare_PagSeguroDireto_Domain_Credentials $credentials, $pageNumber, $maxPageResults, $initialDate, $finalDate = null
  ) {
    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);
    $searchParams = array(
        'initialDate' => Ipagare_PagSeguroDireto_Helper_Helper::formatDate($initialDate),
        'pageNumber' => $pageNumber,
        'maxPageResults' => $maxPageResults
    );

    $searchParams['finalDate'] = $finalDate ? Ipagare_PagSeguroDireto_Helper_Helper::formatDate($finalDate) : null;

    try {
      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->get(
          $this->buildSearchUrlAbandoned($connectionData, $searchParams), $connectionData->getServiceTimeout(), $connectionData->getCharset()
      );

      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());

      switch ($httpStatus->getType()) {
        case 'OK':
          $searchResult = Ipagare_PagSeguroDireto_Parser_TransactionParser::readSearchResult($connection->getResponse());
          break;

        case 'BAD_REQUEST':
          $errors = Ipagare_PagSeguroDireto_Parser_TransactionParser::readErrors($connection->getResponse());
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus, $errors);
          throw $e;
          break;

        default:
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus);
          throw $e;
          break;
      }

      return isset($searchResult) ? $searchResult : false;
    } catch (Ipagare_PagSeguroDireto_Exception_ServiceException $e) {
      throw $e;
    } catch (Exception $e) {
      throw $e;
    }
  }

}
