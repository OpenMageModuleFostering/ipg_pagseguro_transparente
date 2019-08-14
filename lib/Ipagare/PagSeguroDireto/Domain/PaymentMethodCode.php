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
 * Defines a list of known payment method codes.
 */
class Ipagare_PagSeguroDireto_Domain_PaymentMethodCode {
  
  const VISA_CREDIT_CARD = 101;
  const MASTERCARD_CREDIT_CARD = 102;
  const AMEX_CREDIT_CARD = 103;
  const DINERS_CREDIT_CARD = 104;
  const HIPERCARD_CREDIT_CARD = 105;
  const AURA_CREDIT_CARD = 106;
  const ELO_CREDIT_CARD = 107;
  const PLENOCARD = 108;
  const PERSONALCARD = 109;
  const JCB_CREDIT_CARD = 110;
  const DISCOVER_CREDIT_CARD = 111;
  const BRASILCARD = 112;
  const FORTBRASIL_CREDIT_CARD = 113;
  const CARDBAN_CARD = 114;
  const VALECARD_CARD = 115;
  const CABAL_CARD = 116;
  const MAIS_CARD = 117;
  const AVISTA_CARD = 118;
  const GRANDCARD_CARD = 119;
  const SANTANDER_BOLETO = 202;
  const BRADESCO_ONLINE_TRANSFER = 301;
  const ITAU_ONLINE_TRANSFER = 302;
  const BANCO_BRASIL_ONLINE_TRANSFER = 304;
  const BANRISUL_ONLINE_TRANSFER = 306;
  const HSBC_ONLINE_TRANSFER = 307;
  
  private static $codeList  = array('101' => array('codigo'      => 101,
                                                   'nome'        => 'Visa',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::VISA,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '102' => array('codigo'      => 102,
                                                   'nome'        => 'Mastercard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::MASTERCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '103' => array('codigo'      => 103,
                                                   'nome'        => 'Amex',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::AMERICAN_EXPRESS,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '104' => array('codigo'      => 104,
                                                   'nome'        => 'Diners',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::DINERS,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '105' => array('codigo'       => 105,
                                                   'nome'        => 'Hipercard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::HIPERCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     
                                     '106' => array('codigo'       => 106,
                                                   'nome'        => 'Aura',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::AURA,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),

                                     '107' => array('codigo'       => 107,
                                                   'nome'        => 'Elo',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::ELO,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '108' => array('codigo'       => 108,
                                                   'nome'        => 'Plenocard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::PLENOCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '109' => array('codigo'       => 109,
                                                   'nome'        => 'Personalcard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::PERSONALCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '110' => array('codigo'       => 110,
                                                   'nome'        => 'Jcb',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::JCB,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '111' => array('codigo'       => 111,
                                                   'nome'        => 'Discover',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::DISCOVER,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '112' => array('codigo'       => 112,
                                                   'nome'        => 'BrasilCard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::BRASILCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                     '113' => array('codigo'       => 113,
                                                   'nome'        => 'Fortbrasil',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::FORTBRASIL,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '114' => array('codigo'       => 114,
                                                   'nome'        => 'CardBan',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::CARDBAN,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                    '115' => array('codigo'       => 115,
                                                   'nome'        => 'ValeCard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::VALECARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                    
                                    '116' => array('codigo'       => 116,
                                                   'nome'        => 'Cabal',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::CABAL,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                    
                                    '117' => array('codigo'       => 117,
                                                   'nome'        => 'Mais!',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::MAIS,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
                                    
                                    '118' => array('codigo'       => 118,
                                                   'nome'        => 'AVista',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::AVISTA,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                    '119' => array('codigo'       => 119,
                                                   'nome'        => 'GrandCard',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::GRANDCARD,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD)),
        
                                     '202' => array('codigo'       => 202,
                                                   'nome'        => 'Santander - Boleto',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::SANTANDER,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::BOLETO)),
        
                                     '301' => array('codigo'      => 301,
                                                   'nome'        => 'Transferência - Bradesco',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::BRADESCO,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER)),
        
                                     '302' => array('codigo'      => 302,
                                                   'nome'        => 'Transferência - Itaú',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::ITAU,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER)),
        
                                     '304' => array('codigo'      => 304,
                                                   'nome'        => 'Transferência - Banco do Brasil',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::BANCO_BRASIL,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER)),
        
                                     '306' => array('codigo'      => 306,
                                                   'nome'        => 'Transferência - Banrisul',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::BANRISUL,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER)),
                                     '307' => array('codigo'      => 307,
                                                   'nome'        => 'Transferência - HSBC',
                                                   'instituicao' => Ipagare_IpgPagSeguroDireto_Instituicao::HSBC,
                                                   'tipo'        => array(Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER))
                                    );

  /**
   * Payment method code
   * Example: 101
   */
  private $value;
  
  private $nome;
  
  private $instituicao;
  
  private $tipo;

  public function __construct($value = null) {
    if (array_key_exists($value, self::$codeList)) {
      $p = self::$codeList[$value];
      
      $this->value = $p['codigo'];
      $this->nome = $p['nome'];
      $this->instituicao = $p['instituicao'];
      $this->tipo = $p['tipo'];
    } else {
      throw new Ipagare_IpgPagSeguroDireto_RuntimeException("Chave não encontrada para meio de pagamento informado. Chave = " . $value);
    }
  }

  public function setValue($value) {
    $this->value = $value;
  }

  /**
   * @return integer the payment method code value
   * Example: 101
   */
  public function getValue() {
    return $this->value;
  }
  
  public function isAmex() {
    return $this->codigo == self::AMEX_CREDIT_CARD;
  }

  public function isDiners() {
    return $this->codigo == self::DINERS_CREDIT_CARD;
  }

  public function isHipercard() {
    return $this->codigo == self::HIPERCARD_CREDIT_CARD;
  }

  public function isMastercard() {
    return $this->codigo == self::MASTERCARD_CREDIT_CARD;
  }

  public function isVisa() {
    return $this->codigo == self::VISA_CREDIT_CARD;
  }

  public function isBbDebito() {
    return $this->codigo == self::BANCO_BRASIL_ONLINE_TRANSFER;
  }

  public function isBanrisulDebito() {
    return $this->codigo == self::BANRISUL_ONLINE_TRANSFER;
  }

  public function isBradescoDebito() {
    return $this->codigo == self::BRADESCO_ONLINE_TRANSFER;
  }

  public function isItauDebito() {
    return $this->codigo == self::ITAU_ONLINE_TRANSFER;
  }

  public function isHsbcDebito() {
    return $this->codigo == self::HSBC_ONLINE_TRANSFER;
  }

  public function isSantanderBoleto() {
    return $this->codigo == self::SANTANDER_BOLETO;
  }

  public function isAura() {
    return $this->codigo == self::AURA_CREDIT_CARD;
  }

  public function isElo() {
    return $this->codigo == self::ELO_CREDIT_CARD;
  }

  public function isCreditCard() {
    if (!is_array($this->tipo)) {
      return $this->tipo == Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD;
    } else {
      foreach ($this->tipo as $value) {
        if ($value == Ipagare_IpgPagSeguroDireto_TypePaymentType::CREDIT_CARD) {
          return true;
        }
      }
    }
    return false;
  }

  public function isBoleto() {
    if (!is_array($this->tipo)) {
      return $this->tipo == Ipagare_IpgPagSeguroDireto_TypePaymentType::BOLETO;
    } else {
      foreach ($this->tipo as $value) {
        if ($value == Ipagare_IpgPagSeguroDireto_TypePaymentType::BOLETO) {
          return true;
        }
      }
    }
    return false;
  }

  public function isDebitoBancario() {
    if (!is_array($this->tipo)) {
      return $this->tipo == Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER;
    } else {
      foreach ($this->tipo as $value) {
        if ($value == Ipagare_IpgPagSeguroDireto_TypePaymentType::ONLINE_TRANSFER) {
          return true;
        }
      }
    }
    return false;
  }

  public function isPlenoCard() {
    return $this->codigo == self::PLENOCARD;
  }

  public function isPersonalCard() {
    return $this->codigo == self::PERSONALCARD;
  }

  public function isJcbCreditCard() {
    return $this->codigo == self::JCB_CREDIT_CARD;
  }

  public function isDiscoverCreditCard() {
    return $this->codigo == self::DISCOVER_CREDIT_CARD;
  }

  public function isBrasilCard() {
    return $this->codigo == self::BRASILCARD;
  }

  public function isFortBrasilCreditCard() {
    return $this->codigo == self::FORTBRASIL_CREDIT_CARD;
  }

  public function isCardbanCard() {
    return $this->codigo == self::CARDBAN_CARD;
  }

  public function isValecardCard() {
    return $this->codigo == self::VALECARD_CARD;
  }

  public function isCabalCard() {
    return $this->codigo == self::CABAL_CARD;
  }

  public function isMaisCard() {
    return $this->codigo == self::MAIS_CARD;
  }

  public function isAvistaCard() {
    return $this->codigo == self::AVISTA_CARD;
  }

  public function isGrandCardCard() {
    return $this->codigo == self::GRANDCARD_CARD;
  }

  public function getInstituicao() {
    return $this->instituicao;
  }

  public function setInstituicao($instituicao) {
    $this->instituicao = $instituicao;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }

  public function getNome() {
    return $this->nome;
  }

  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }

  public function getTipo() {
    return $this->tipo;
  }

  public function getBandeira() {
    return strtolower($this->instituicao);
  }
}
