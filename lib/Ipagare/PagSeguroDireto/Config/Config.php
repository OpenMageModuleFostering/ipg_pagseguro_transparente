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
 * Provides a means to retrieve configuration preferences.
 * These preferences can come from the default config file (Ipagare_PagSeguroDireto_Library/config/Ipagare_PagSeguroDireto_Config_Config.php).
 */

class Ipagare_PagSeguroDireto_Config_Config {

  private static $config;
  private static $data;

  const VARNAME = 'PagSeguroDiretoConfig';

  private function __construct() {
    define('ALLOW_IPAGARE_PAGSEGURODIRETO_CONFIG', true);

    require_once Ipagare_PagSeguroDireto_Library::getPath() .
        DIRECTORY_SEPARATOR . "Config" . DIRECTORY_SEPARATOR . "ConfigFile.php";
    $varName = self::VARNAME;

    if (isset($$varName)) {
      self::$data = $$varName;
      unset($$varName);
    } else {
      throw new Exception("Config is undefined.");
    }
  }

  public static function init() {
    if (self::$config == null) {
      self::$config = new Ipagare_PagSeguroDireto_Config_Config();
    }

    return self::$config;
  }

  public static function getData($key1, $key2 = null) {
    if ($key2 != null) {
      if (isset(self::$data[$key1][$key2])) {
        return self::$data[$key1][$key2];
      } else {
        throw new Exception("Config keys {$key1}, {$key2} not found.");
      }
    } else {
      if (isset(self::$data[$key1])) {
        return self::$data[$key1];
      } else {
        throw new Exception("Config key {$key1} not found.");
      }
    }
  }

  public static function setData($key1, $key2, $value) {
    if (isset(self::$data[$key1][$key2])) {
      self::$data[$key1][$key2] = $value;
    } else {
      throw new Exception("Config keys {$key1}, {$key2} not found.");
    }
  }

  public static function getEnvironment() {
    if (isset(self::$data['environment']) && isset(self::$data['environment']['environment'])) {
      return self::$data['environment']['environment'];
    } else {
      throw new Exception("Environment not set.");
    }
  }

  public static function getApplicationCharset() {
    if (isset(self::$data['application']) && isset(self::$data['application']['charset'])) {
      return self::$data['application']['charset'];
    } else {
      throw new Exception("Application charset not set.");
    }
  }

  public static function setApplicationCharset($charset) {
    self::setData('application', 'charset', $charset);
  }

  /**
   * Validate if the requirements are enable for use correct of the Ipagare_PagSeguroDireto_
   * @return array
   */
  public static function validateRequirements() {

    $requirements = array(
        'version' => '',
        'spl' => '',
        'curl' => '',
        'dom' => ''
    );

    $version = str_replace('.', '', phpversion());

    if ($version < 533) {
      $requirements['version'] = 'Ipagare_PagSeguroDireto_Library: PHP version 5.3.3 or greater is required.';
    }

    if (!function_exists('spl_autoload_register')) {
      $requirements['spl'] = 'Ipagare_PagSeguroDireto_Library: Standard PHP Library (SPL) is required.';
    }

    if (!function_exists('curl_init')) {
      $requirements['curl'] = 'Ipagare_PagSeguroDireto_Library: cURL library is required.';
    }

    if (!class_exists('DOMDocument')) {
      $requirements['dom'] = 'Ipagare_PagSeguroDireto_Library: DOM XML extension is required.';
    }

    return $requirements;
  }

}
