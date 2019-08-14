<?php

class Ipagare_PagSeguroDireto_Service_SessionService {

  /**
   *
   */
  const SERVICE_NAME = 'sessionService';

  /**
   * @param Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData
   * @return string
   */
  private static function buildSessionUrl(Ipagare_PagSeguroDireto_Service_ConnectionData $connectionData) {
    return $connectionData->getServiceUrl() . '/?' . $connectionData->getCredentialsUrlQuery();
  }

  /**
   * Returns a transaction from a notification code
   *
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param String $notificationCode
   * @throws Ipagare_PagSeguroDireto_Exception_ServiceException
   * @throws Exception
   * @return Ipagare_PagSeguroDireto_Domain_Session
   * @see Ipagare_PagSeguroDireto_Domain_Transaction
   */
  public static function createSession(Ipagare_PagSeguroDireto_Domain_Credentials $credentials) {
    $connectionData = new Ipagare_PagSeguroDireto_Service_ConnectionData($credentials, self::SERVICE_NAME);

    try {
      $connection = new Ipagare_PagSeguroDireto_Utils_HttpConnection();
      $connection->post(self::buildSessionUrl($connectionData), array(), $connectionData->getServiceTimeout(), $connectionData->getCharset());

      $httpStatus = new Ipagare_PagSeguroDireto_Domain_HttpStatus($connection->getStatus());
      $sessionResponse = new Ipagare_PagSeguroDireto_Domain_SessionResponse();

      switch ($httpStatus->getType()) {
        case 'OK':
          $session = Ipagare_PagSeguroDireto_Parser_SessionParser::readXml($connection->getResponse());
          $sessionResponse->setSession($session);
          break;

        case 'BAD_REQUEST':
          $errors = Ipagare_PagSeguroDireto_Parser_SessionParser::readErrors($connection->getResponse());
          $sessionResponse->setErrors($errors);
          break;

        case 'UNAUTHORIZED':
          $errors = array(new Ipagare_IpgPagSeguroDireto_ErrorMessages('UNAUTHORIZED'));
          $sessionResponse->setErrors($errors);
          break;

        default:
          $e = new Ipagare_PagSeguroDireto_Exception_ServiceException($httpStatus);
          $sessionResponse->addFatalError($e->getOneLineMessage());
          break;
      }
    } catch (Ipagare_PagSeguroDireto_Exception_ServiceException $e) {
      
    } catch (Exception $e) {
      
    }

    return $sessionResponse;
  }

}
