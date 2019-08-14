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

class Ipagare_PagSeguroDireto_Library {

  const VERSION = '1.1.3';

  public static $resources;
  public static $config;
  private static $path;
  private static $library;
  private static $php_version;

  private function __construct() {
    self::$path = (dirname(__FILE__));
    //Ipagare_PagSeguroDireto_Loader_Autoloader::init();
    self::$resources = Ipagare_PagSeguroDireto_Resources_Resources::init();
    self::$config = Ipagare_PagSeguroDireto_Config_Config::init();
  }

  public static function init() {
    //require_once "Loader" . DIRECTORY_SEPARATOR . "Ipagare/AutoLoader.php";
    self::verifyDependencies();
    if (self::$library == null) {
      self::$library = new Ipagare_PagSeguroDireto_Library();
    }
    return self::$library;
  }

  private static function verifyDependencies() {
    $dependencies = true;

    try {
      if (!function_exists('spl_autoload_register')) {
        $dependencies = false;
        throw new Exception("Ipagare_PagSeguroDireto_Library: Standard PHP Library (SPL) is required.");
      }

      if (!function_exists('curl_init')) {
        $dependencies = false;
        throw new Exception('Ipagare_PagSeguroDireto_Library: cURL library is required.');
      }

      if (!class_exists('DOMDocument')) {
        $dependencies = false;
        throw new Exception('Ipagare_PagSeguroDireto_Library: DOM XML extension is required.');
      }
    } catch (Exception $e) {
      return $dependencies;
    }

    return $dependencies;
  }

  final public static function getVersion() {
    return self::VERSION;
  }

  final public static function getPath() {
    return self::$path;
  }

  final public static function getModuleVersion() {
    return 'ipagare:1.1.3';
  }

  final public static function getPHPVersion() {
    return self::$php_version = phpversion();
  }

  final public static function setPHPVersion($version) {
    self::$php_version = $version;
  }

  final public static function getCMSVersion() {
    return 'magento:' . Mage::getVersion();
  }

}

Ipagare_PagSeguroDireto_Library::init();
