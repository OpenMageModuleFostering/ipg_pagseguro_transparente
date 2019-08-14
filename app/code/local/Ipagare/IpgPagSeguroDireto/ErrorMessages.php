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

class Ipagare_IpgPagSeguroDireto_ErrorMessages {

  private static $list = array(
      'UNAUTHORIZED' => array('message' => 'Não foi possível conectar com o PagSeguro. Por favor, verifique se seu convênio está correto.'),
      '53004' => array('message' => 'quantidade de itens é inválido.'),
      '53005' => array('message' => 'Moeda é obrigatório.'),
      '53006' => array('message' => 'Moeda contém valor inválido.'),
      '53007' => array('message' => 'Código de referência contém tamanho inválido.'),
      '53008' => array('message' => 'URL de notificação contém tamanho inválido.'),
      '53009' => array('message' => 'URL de notificação contém valor inválido.'),
      '53010' => array('message' => 'E-mail do remetente é obrigatório.'),
      '53011' => array('message' => 'E-mail do remetente contém tamanho inválido.'),
      '53012' => array('message' => 'E-mail do remetente contém valor inválido.'),
      '53013' => array('message' => 'E-mail do remetente é obrigatório.'),
      '53014' => array('message' => 'E-mail do remetente contém tamanho inválido.'),
      '53015' => array('message' => 'CPF do remetente contém valor inválido.'),
      '53017' => array('message' => 'CPF do remetente contém valor inválido.'),
      '53018' => array('message' => 'Código de área do telefone é obrigatório.'),
      '53019' => array('message' => 'Código de área do telefone é inválido.'),
      '53020' => array('message' => 'Telefone do remetente é é obrigatório.'),
      '53021' => array('message' => 'Telefone do remetente é inválido.'),
      '53022' => array('message' => 'CEP do endereço de entrega é obrigatório.'),
      '53023' => array('message' => 'CEP do endereço de entrega contém valor inválido.'),
      '53024' => array('message' => 'Endereço de entrega é obrigatório.'),
      '53025' => array('message' => 'Endereço do endereço de entrega contém tamanho inválido.'),
      '53026' => array('message' => 'Número do endereço de entrega é obrigatório.'),
      '53027' => array('message' => 'Número do endereço de entrega contém tamanho inválido.'),
      '53028' => array('message' => 'Campo "complemento" do endereço de entrega contém tamanho inválido.'),
      '53029' => array('message' => 'Campo "bairro" do endereço de entrega é obrigatório.'),
      '53030' => array('message' => 'Campo "bairro" do endereço de entrega contém tamanho inválido.'),
      '53031' => array('message' => 'Cidade do endereço de entrega é obrigatório.'),
      '53032' => array('message' => 'Cidade do endereço de entrega contém tamanho inválido.'),
      '53033' => array('message' => 'Estado do endereço de entrega é obrigatório.'),
      '53034' => array('message' => 'Estado do endereço de entrega contém valor inválido.'),
      '53035' => array('message' => 'País do endereço de entrega é obrigatório.'),
      '53036' => array('message' => 'País do endereço de entrega contém tamanho inválido.'),
      '53037' => array('message' => 'Número do Cartão de Crédito é inválido.'),
      '53038' => array('message' => 'Quantidade de parcelas é obrigatório.'),
      '53039' => array('message' => 'Quantidade de parcelas contém valor inválido.'),
      '53040' => array('message' => 'Valor da parcela é obrigatório.'),
      '53041' => array('message' => 'Valor da parcela contém valor inválido.'),
      '53042' => array('message' => 'Nome do portador do cartão de crédito é obrigatório.'),
      '53043' => array('message' => 'Nome do portador do cartão de crédito contém tamanho inválido.'),
      '53044' => array('message' => 'Nome do portador do cartão de crédito contém valor inválido.'),
      '53045' => array('message' => 'CPF do portador do cartão de crédito é obrigatório.'),
      '53046' => array('message' => 'CPF do portador do cartão de crédito contém valor inválido.'),
      '53047' => array('message' => 'Data de nascimento do portador do cartão de crédito é obrigatório.'),
      '53048' => array('message' => 'Data de nascimento do portador do cartão de crédito contém valor inválido.'),
      '53049' => array('message' => 'Código de área do telefone do portador do cartão de crédito é obrigatório.'),
      '53050' => array('message' => 'Código de área do telefone do portador do cartão de crédito contém valor inválido.'),
      '53051' => array('message' => 'Telefone do portador do cartão de crédito é obrigatório.'),
      '53052' => array('message' => 'Telefone do portador do cartão de crédito contém valor inválido.'),
      '53053' => array('message' => 'CEP do endereço de cobrança é obrigatório.'),
      '53054' => array('message' => 'CEP do endereço de cobrança contém valor inválido.'),
      '53055' => array('message' => 'Endereço de cobrança é obrigatório.'),
      '53056' => array('message' => 'Endereço de cobrança contém tamanho inválido.'),
      '53057' => array('message' => 'Número do endereço de cobrança é obrigatório.'),
      '53058' => array('message' => 'Número do endereço de cobrança contém tamanho inválido.'),
      '53059' => array('message' => 'Campo "complemento" do endereço de cobrança contém tamanho inválido.'),
      '53060' => array('message' => 'Campo "bairro" do endereço de cobrança é obrigatório.'),
      '53061' => array('message' => 'Campo "bairro" do endereço de cobrança contém tamanho inválido.'),
      '53062' => array('message' => 'Campo "cidade" do endereço de cobrança é obrigatório.'),
      '53063' => array('message' => 'Campo "cidade" do endereço de cobrança contém tamanho inválido.'),
      '53064' => array('message' => 'Campo "estado" do endereço de cobrança é obrigatório.'),
      '53065' => array('message' => 'Campo "estado" do endereço de cobrança contém valor inválido.'),
      '53066' => array('message' => 'Campo "país" do endereço de cobrança é obrigatório.'),
      '53067' => array('message' => 'Campo "país" do endereço de cobrança contém tamanho inválido.'),
      '53068' => array('message' => 'E-mail do recebedor contém tamanho inválido.'),
      '53069' => array('message' => 'E-mail do recebedor contém valor inválido.'),
      '53070' => array('message' => 'ID do item é obrigatório.'),
      '53071' => array('message' => 'ID do item contém tamanho inválido.'),
      '53072' => array('message' => 'Descrição do item é obrigatório.'),
      '53073' => array('message' => 'Descrição do item contém tamanho inválido.'),
      '53074' => array('message' => 'Quantidade do item é obrigatório.'),
      '53075' => array('message' => 'Quantidade do item está fora do intervalo permitido.'),
      '53076' => array('message' => 'Quantidade do item contém valor inválido.'),
      '53077' => array('message' => 'Valor do item é obrigatório.'),
      '53078' => array('message' => 'Valor do item está formatado de maneira errada.'),
      '53079' => array('message' => 'Valor do item está fora do intervalo permitido.'),
      '53081' => array('message' => 'O remetente está relacionado com o Recebedor.'),
      '53084' => array('message' => 'Recebedor inválido: verifique o status da conta do recebedor e se a conta é do tipo conta de vendedor.'),
      '53085' => array('message' => 'Método de pagamento indisponível. Por favor, tente novamente mais tarde ou escolha outra opção de pagamento.'),
      '53086' => array('message' => 'Total do pedido está fora do intervalo permitido.'),
      '53087' => array('message' => 'Informações do cartão de crédito são inválidas.'),
      '53091' => array('message' => 'Hash do remetente é inválida.'),
      '53092' => array('message' => 'Bandeira do cartão de crédito não é aceita.'),
      '53095' => array('message' => 'Tipo de frete contém valor inválido.'),
      '53096' => array('message' => 'Custo do frete contém valor inválido.'),
      '53097' => array('message' => 'Custo do frete está fora do intervalo permitido.'),
      '53098' => array('message' => 'Total do pedido contém valor negativo.'),
      '53099' => array('message' => 'Valor extra está fora do intervalo permitido.'),
      '53101' => array('message' => 'Modo de pagamento contém valor inválido. Os valores aceitos são "default" e "gateway".'),
      '53102' => array('message' => 'Método de pagamento contém valor inválido. Os valores aceitos são "creditCard", "boleto" e "eft".'),
      '53104' => array('message' => 'Custo de transporte foi informado, endereço de entrega deve ser completo.'),
      '53105' => array('message' => 'E-mail do remetente também deve ser informado.'),
      '53106' => array('message' => 'Informações do portador do cartão de crédito estão incompletas.'),
      '53109' => array('message' => 'E-mail do remetente também deve ser informado.'),
      '53110' => array('message' => 'Banco é obrigatório.'),
      '53111' => array('message' => 'Banco não aceito.'),
      '53115' => array('message' => 'Data de nascimento do remetente contém valor inválido.'),
      '53118' => array('message' => 'CPF/CNPJ do comprador é obrigatório.'),
      '53121' => array('message' => 'Pagamento com cartão de crédito empresarial não é permitido para este vendedor.'),
      '53122' => array('message' => 'Domínio do e-mail do remetente deve conter @sandbox.pagseguro.com.br.'),
      '53140' => array('message' => 'Quantidade de parcelas está fora do intervalo permitido.'),
      '53141' => array('message' => 'O PagSeguro identificou problemas em sua conta.'),
      '53142' => array('message' => 'Número do Cartão de Crédito é inválido.'),
      '53150' => array('message' => 'Por favor, tente realizar o pagamento novamente (verifique se o número de seu cartão está correto).')
  );

  /**
   *
   * @var string
   */
  private $code;

  /**
   *
   * @var string
   */
  private $message;

  public function __construct($code) {
    if (array_key_exists($code, self::$list)) {
      $v = self::$list[$code];

      $this->code = $code;
      $this->message = $v['message'];
    } else {
      $this->code = $code;
      $this->message = 'Não foi possível processar o pagamento.';
    }
  }

  public function getCode() {
    return $this->code;
  }

  public function getMessage() {
    return $this->message;
  }

  public function setCode($code) {
    $this->code = $code;
  }

  public function setMessage($message) {
    $this->message = $message;
  }

}
