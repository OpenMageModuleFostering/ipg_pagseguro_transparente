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
 * Represents the party on the transaction that is sending the money
 */
class Ipagare_PagSeguroDireto_Domain_Sender {

  /** Sender name */
  private $name;

  /** Sender email */
  private $email;

  /** Sender phone */
  private $phone;

  /** Hash */
  private $hash;

  /** Sender documents */
  private $documents;

  /**
   * Initializes a new instance of the Sender class
   *
   * @param array $data
   */
  public function __construct(array $data = null) {
    if ($data) {
      if (isset($data['name'])) {
        $this->name = $data['name'];
      }
      if (isset($data['email'])) {
        $this->email = $data['email'];
      }
      if (isset($data['hash'])) {
        $this->hash = $data['hash'];
      }
      if (isset($data['phone']) && $data['phone'] instanceof Ipagare_PagSeguroDireto_Domain_Phone) {
        $this->phone = $data['phone'];
      } else {
        if (isset($data['areaCode']) && isset($data['number'])) {
          $phone = new Ipagare_PagSeguroDireto_Domain_Phone($data['areaCode'], $data['number']);
          $this->phone = $phone;
        }
      }
      if (isset($data['documents']) && is_array($data['documents'])) {
        $this->setDocuments($data['documents']);
      }
    }
  }

  /**
   * Sets the sender name
   * @param String $name
   */
  public function setName($name) {
    $this->name = Ipagare_PagSeguroDireto_Helper_Helper::formatString($name, 50, '');
  }

  /**
   * @return String the sender name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Sets the Sender e-mail
   * @param email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * @return String the sender e-mail
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Sets the sender phone
   * @param String $areaCode
   * @param String $number
   */
  public function setPhone($areaCode, $number = null) {
    $param = $areaCode;
    if ($param instanceof Ipagare_PagSeguroDireto_Domain_Phone) {
      $this->phone = $param;
    } elseif ($number) {
      $phone = new Ipagare_PagSeguroDireto_Domain_Phone();
      $phone->setAreaCode($areaCode);
      $phone->setNumber($number);
      $this->phone = $phone;
    }
  }

  /**
   * @return Ipagare_PagSeguroDireto_Domain_Phone the sender phone
   * @see Ipagare_PagSeguroDireto_Domain_Phone
   */
  public function getPhone() {
    return $this->phone;
  }

  /**
   * Get Sender documents
   * @return array Ipagare_PagSeguroDireto_Domain_Document List of Ipagare_PagSeguroDireto_Domain_Document
   * @see Ipagare_PagSeguroDireto_Domain_Document
   */
  public function getDocuments() {
    return $this->documents;
  }

  /**
   * Set Ipagare_PagSeguroDireto_ documents
   * @param array $documents
   * @see Ipagare_PagSeguroDireto_Domain_Document
   */
  public function setDocuments(array $documents) {
    if (count($documents) > 0) {
      foreach ($documents as $document) {
        if ($document instanceof Ipagare_PagSeguroDireto_Domain_SenderDocument) {
          $this->documents[] = $document;
        } else {
          if (is_array($document)) {
            $this->addDocument($document['type'], $document['value']);
          }
        }
      }
    }
  }

  /**
   * Add a document for Sender object
   * @param String $type
   * @param String $value
   */
  public function addDocument($type, $value) {
    if ($type && $value) {
      if (count($this->documents) == 0) {
        $document = new Ipagare_PagSeguroDireto_Domain_SenderDocument($type, $value);
        $this->documents[] = $document;
      }
    }
  }

  public function getHash() {
    return $this->hash;
  }

  public function setHash($hash) {
    $this->hash = $hash;
  }
}
