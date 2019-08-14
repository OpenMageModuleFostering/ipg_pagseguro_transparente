<?php

class Ipagare_PagSeguroDireto_Service_ConnectionData {

  /**
   * @var
   */
  private $serviceName;

  /**
   * @var Ipagare_PagSeguroDireto_Domain_Credentials
   */
  private $credentials;

  /**
   * @var
   */
  private $resources;

  /**
   * @var
   */
  private $environment;

  /**
   * @var
   */
  private $webserviceUrl;

  /**
   * @var
   */
  private $transactionUrl;

  /**
   * @var
   */
  private $servicePath;

  /**
   * @var
   */
  private $serviceTimeout;

  /**
   * @var
   */
  private $charset;

  /**
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   * @param $serviceName
   */
  public function __construct(Ipagare_PagSeguroDireto_Domain_Credentials $credentials, $serviceName) {
    $this->credentials = $credentials;
    $this->serviceName = $serviceName;

    $this->setEnvironment(Ipagare_PagSeguroDireto_Config_Config::getEnvironment());
    $this->setTransactionUrl(Ipagare_PagSeguroDireto_Resources_Resources::getTransactionUrl($this->getEnvironment()));
    $this->setWebserviceUrl(Ipagare_PagSeguroDireto_Resources_Resources::getWebserviceUrl($this->getEnvironment()));
    $this->setCharset(Ipagare_PagSeguroDireto_Config_Config::getApplicationCharset());

    $this->resources = Ipagare_PagSeguroDireto_Resources_Resources::getData($this->serviceName);
    if (isset($this->resources['servicePath'])) {
      $this->setServicePath($this->resources['servicePath']);
    }
    if (isset($this->resources['serviceTimeout'])) {
      $this->setServiceTimeout($this->resources['serviceTimeout']);
    }
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Credentials
   */
  public function getCredentials() {
    return $this->credentials;
  }

  /**
   * @param Ipagare_PagSeguroDireto_Domain_Credentials $credentials
   */
  public function setCredentials(Ipagare_PagSeguroDireto_Domain_Credentials $credentials) {
    $this->credentials = $credentials;
  }

  /**
   * @return string
   */
  public function getCredentialsUrlQuery() {
    return http_build_query($this->credentials->getAttributesMap(), '', '&');
  }

  /**
   * @return mixed
   */
  public function getEnvironment() {
    return $this->environment;
  }

  /**
   * @param $environment
   */
  public function setEnvironment($environment) {
    $this->environment = $environment;
  }

  /**
   * @return mixed
   */
  public function getWebserviceUrl() {
    return $this->webserviceUrl;
  }

  /**
   * @param $webserviceUrl
   */
  public function setWebserviceUrl($webserviceUrl) {
    $this->webserviceUrl = $webserviceUrl;
  }

  /**
   * @return mixed
   */
  public function getServicePath() {
    return $this->servicePath;
  }

  /**
   * @param $servicePath
   */
  public function setServicePath($servicePath) {
    $this->servicePath = $servicePath;
  }

  /**
   * @return mixed
   */
  public function getServiceTimeout() {
    return $this->serviceTimeout;
  }

  /**
   * @param $serviceTimeout
   */
  public function setServiceTimeout($serviceTimeout) {
    $this->serviceTimeout = $serviceTimeout;
  }

  /**
   * @return string
   */
  public function getServiceUrl() {
    return $this->getWebserviceUrl() . $this->getServicePath();
  }

  /**
   * @param $resource
   * @return mixed
   */
  public function getResource($resource) {
    return $this->resources[$resource];
  }

  /**
   * @return mixed
   */
  public function getCharset() {
    return $this->charset;
  }

  /**
   * @param $charset
   */
  public function setCharset($charset) {
    $this->charset = $charset;
  }

  public function getTransactionUrl() {
    return $this->transactionUrl;
  }

  public function setTransactionUrl($transactionUrl) {
    $this->transactionUrl = $transactionUrl;
  }

}
