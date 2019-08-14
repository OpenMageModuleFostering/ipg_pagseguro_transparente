<?php

/**
* 
* iPAGARE para Magento
* 
* @category     Ipagare
* @packages     IpgBase
* @copyright    Copyright (c) 2012 iPAGARE (http://www.ipagare.com.br)
* @version      1.16.4
* @license      http://www.ipagare.com.br/magento/licenca
*
*/

class Ipagare_IpgBase_ConfiguracoesSystem {
    
    // Página de sucesso
    const PAGINA_SUCESSO_MOSTRAR_CONTEUDO = 'ipgbase/pagina_sucesso/mostrar_conteudo';
    
    // Expiração pedidos
    const EXPIRACAO_PEDIDO_ACTIVE = 'ipgbase/expiracao_pedido/ativa';
    const EXPIRACAO_PEDIDO_DATA_INICIAL = 'ipgbase/expiracao_pedido/data_inicial';
    const EXPIRACAO_PEDIDO_PERIODO_DIAS = 'ipgbase/expiracao_pedido/periodo_dias';
    const EXPIRACAO_PEDIDO_PERIODO_HORAS = 'ipgbase/expiracao_pedido/periodo_horas';
    const EXPIRACAO_PEDIDO_PERIODO_MINUTOS = 'ipgbase/expiracao_pedido/periodo_minutos';
    
    // Página de estilo OSC
    const OSC_CSS_ACTIVE = 'ipgbase/osc/css_active';
    
    const REENVIO_BOLETO_ATIVO = 'ipgbase/reenvio_boleto/ativa';
    const REENVIO_BOLETO_NUMERO_DIAS = 'ipgbase/reenvio_boleto/numero_dias';
    
      //Controle do envio de e-mails
    const CONTROLE_ENVIO_EMAIL_NOVO = 'ipgbase/controle_envio_email/novo';
    const CONTROLE_ENVIO_EMAIL_CANCELADO = 'ipgbase/controle_envio_email/cancelado';
    const CONTROLE_ENVIO_EMAIL_FATURA_GERADA = 'ipgbase/controle_envio_email/fatura_gerada';
    
}