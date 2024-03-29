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
 * Abstract class that represents a Ipagare_PagSeguroDireto_ credential
 */
abstract class Ipagare_PagSeguroDireto_Domain_Credentials {

  /**
   * @return array a map of name value pairs that compose this set of credentials
   */
  abstract public function getAttributesMap();

  /**
   * @return string a string that represents the current object
   */
  abstract public function toString();
}
