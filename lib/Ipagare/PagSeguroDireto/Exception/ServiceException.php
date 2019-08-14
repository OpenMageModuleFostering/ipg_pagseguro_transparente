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

/*
 * Represents a exception behavior
 * */

/**
 * Class Ipagare_PagSeguroDireto_Exception_ServiceException
 */
class Ipagare_PagSeguroDireto_Exception_ServiceException extends Exception {

  /**
   * @var Ipagare_PagSeguroDireto_Domain_HttpStatus
   */
  private $httpStatus;

  /**
   * @var
   */
  private $httpMessage;

  /**
   * @var array
   */
  private $errors = array();

  /**
   * @param Ipagare_PagSeguroDireto_Domain_HttpStatus $httpStatus
   * @param array $errors
   */
  public function __construct(Ipagare_PagSeguroDireto_Domain_HttpStatus $httpStatus, array $errors = null) {
    $this->httpStatus = $httpStatus;
    if ($errors) {
      $this->errors = $errors;
    }
    $this->httpMessage = $this->getFormattedMessage();
  }

  /**
   * @return array
   */
  public function getErrors() {
    return $this->errors;
  }

  /**
   * @param array $errors
   */
  public function setErrors(array $errors) {
    $this->errors = $errors;
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_HttpStatus
   */
  public function getHttpStatus() {
    return $this->httpStatus;
  }

  /**
   * @param Ipagare_PagSeguroDireto_Domain_HttpStatus $httpStatus
   */
  public function setHttpStatus(Ipagare_PagSeguroDireto_Domain_HttpStatus $httpStatus) {
    $this->httpStatus = $httpStatus;
  }

  /**
   * @return string
   */
  private function getHttpMessage() {
    switch ($this->httpStatus->getType()) {

      case 'BAD_REQUEST':
        $message = "BAD_REQUEST";
        break;

      case 'UNAUTHORIZED':
        $message = "UNAUTHORIZED";
        break;

      case 'FORBIDDEN':
        $message = "FORBIDDEN";
        break;

      case 'NOT_FOUND':
        $message = "NOT_FOUND";
        break;

      case 'INTERNAL_SERVER_ERROR':
        $message = "INTERNAL_SERVER_ERROR";
        break;

      case 'BAD_GATEWAY':
        $message = "BAD_GATEWAY";
        break;

      default:
        $message = "UNDEFINED";
        break;
    }
    return $message;
  }

  /**
   * @return string
   */
  public function getFormattedMessage() {
    $message = "";
    $message .= "[HTTP " . $this->httpStatus->getStatus() . "] - " . $this->getHttpMessage() . "\n";
    foreach ($this->errors as $key => $value) {
      if ($value instanceof Ipagare_PagSeguroDireto_Domain_Error) {
        $message .= "$key [" . $value->getCode() . "] - " . $value->getMessage();
      }
    }
    return $message;
  }

  /**
   * @return mixed
   */
  public function getOneLineMessage() {
    return str_replace("\n", " ", $this->getFormattedMessage());
  }

}
