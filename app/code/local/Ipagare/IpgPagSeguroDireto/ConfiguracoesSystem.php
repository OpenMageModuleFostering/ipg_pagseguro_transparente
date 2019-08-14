<?php

/**
* 
* iPAGARE PagSeguro para Magento
* 
* @category     Ipagare
* @packages     IpgPagSeguroDireto
* @copyright    Copyright (c) 2014 iPAGARE (http://www.ipagare.com.br)
* @version      1.1.3
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

class Ipagare_IpgPagSeguroDireto_ConfiguracoesSystem {

  // payment method
  const ACTIVE = 'payment/ipgpagsegurodireto/active';
  const INVOICE = 'ipgpagsegurodireto/geral/invoice';
  const CANCEL_ORDER = 'ipgpagsegurodireto/geral/cancel_order';
  const EMAIL = 'ipgpagsegurodireto/geral/email';
  const TOKEN = 'ipgpagsegurodireto/geral/token';
  const CUSTOM_CSS = 'ipgpagsegurodireto/geral/custom_css';
  // cartao
  const CARTAO_ACTIVE = 'ipgpagsegurodireto/cartao/active';
  const CARTAO_CODIGOS = 'ipgpagsegurodireto/cartao/codigos';
  const CARTAO_VALOR_MINIMO = 'ipgpagsegurodireto/cartao/valor_minimo';
  const CARTAO_VALOR_MAXIMO = 'ipgpagsegurodireto/cartao/valor_maximo';
  const CARTAO_DESCONTO_AVISTA = 'ipgpagsegurodireto/cartao/desconto_avista';
  // debito
  const DEBITO_ACTIVE = 'ipgpagsegurodireto/debito/active';
  const DEBITO_CODIGOS = 'ipgpagsegurodireto/debito/codigos';
  const DEBITO_VALOR_MINIMO = 'ipgpagsegurodireto/debito/valor_minimo';
  const DEBITO_VALOR_MAXIMO = 'ipgpagsegurodireto/debito/valor_maximo';
  const DEBITO_DESCONTO_AVISTA = 'ipgpagsegurodireto/debito/desconto_avista';
  // boleto
  const BOLETO_ACTIVE = 'ipgpagsegurodireto/boleto/active';
  const BOLETO_CODIGOS = 'ipgpagsegurodireto/boleto/codigos';
  const BOLETO_VALOR_MINIMO = 'ipgpagsegurodireto/boleto/valor_minimo';
  const BOLETO_VALOR_MAXIMO = 'ipgpagsegurodireto/boleto/valor_maximo';
  const BOLETO_DESCONTO_AVISTA = 'ipgpagsegurodireto/boleto/desconto_avista';
  // sender_email
  const SENDER_EMAIL = 'ipgpagsegurodireto/environment/sender_email';

}
