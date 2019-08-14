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

final class Ipagare_IpgPagSeguroDireto_Config {

  const ERROR_001 = '001';
  const ERROR_002 = '002';

  protected static $_paymentModes = array('A01' => array('parcelas' => 1, 'codigo' => 'A01', 'juros' => false),
                                          'A02' => array('parcelas' => 2, 'codigo' => 'A02', 'juros' => false),
                                          'A03' => array('parcelas' => 3, 'codigo' => 'A03', 'juros' => false),
                                          'A04' => array('parcelas' => 4, 'codigo' => 'A04', 'juros' => false),
                                          'A05' => array('parcelas' => 5, 'codigo' => 'A05', 'juros' => false),
                                          'A06' => array('parcelas' => 6, 'codigo' => 'A06', 'juros' => false),
                                          'A07' => array('parcelas' => 7, 'codigo' => 'A07', 'juros' => false),
                                          'A08' => array('parcelas' => 8, 'codigo' => 'A08', 'juros' => false),
                                          'A09' => array('parcelas' => 9, 'codigo' => 'A09', 'juros' => false),
                                          'A10' => array('parcelas' => 10, 'codigo' => 'A10', 'juros' => false),
                                          'A11' => array('parcelas' => 11, 'codigo' => 'A11', 'juros' => false),
                                          'A12' => array('parcelas' => 12, 'codigo' => 'A12', 'juros' => false),
                                          'A13' => array('parcelas' => 13, 'codigo' => 'A13', 'juros' => false),
                                          'A14' => array('parcelas' => 14, 'codigo' => 'A14', 'juros' => false),
                                          'A15' => array('parcelas' => 15, 'codigo' => 'A15', 'juros' => false),
                                          'A16' => array('parcelas' => 16, 'codigo' => 'A16', 'juros' => false),
                                          'A17' => array('parcelas' => 17, 'codigo' => 'A17', 'juros' => false),
                                          'A18' => array('parcelas' => 18, 'codigo' => 'A18', 'juros' => false),
                                          'A19' => array('parcelas' => 19, 'codigo' => 'A19', 'juros' => false),
                                          'A20' => array('parcelas' => 20, 'codigo' => 'A20', 'juros' => false),
                                          'A21' => array('parcelas' => 21, 'codigo' => 'A21', 'juros' => false),
                                          'A22' => array('parcelas' => 22, 'codigo' => 'A22', 'juros' => false),
                                          'A23' => array('parcelas' => 23, 'codigo' => 'A23', 'juros' => false),
                                          'A24' => array('parcelas' => 24, 'codigo' => 'A24', 'juros' => false),
                                          'B02' => array('parcelas' => 2, 'codigo' => 'B02', 'juros' => true),
                                          'B03' => array('parcelas' => 3, 'codigo' => 'B03', 'juros' => true),
                                          'B04' => array('parcelas' => 4, 'codigo' => 'B04', 'juros' => true),
                                          'B05' => array('parcelas' => 5, 'codigo' => 'B05', 'juros' => true),
                                          'B06' => array('parcelas' => 6, 'codigo' => 'B06', 'juros' => true),
                                          'B07' => array('parcelas' => 7, 'codigo' => 'B07', 'juros' => true),
                                          'B08' => array('parcelas' => 8, 'codigo' => 'B08', 'juros' => true),
                                          'B09' => array('parcelas' => 9, 'codigo' => 'B09', 'juros' => true),
                                          'B10' => array('parcelas' => 10, 'codigo' => 'B10', 'juros' => true),
                                          'B11' => array('parcelas' => 11, 'codigo' => 'B11', 'juros' => true),
                                          'B12' => array('parcelas' => 12, 'codigo' => 'B12', 'juros' => true),
                                          'B13' => array('parcelas' => 13, 'codigo' => 'B13', 'juros' => true),
                                          'B14' => array('parcelas' => 14, 'codigo' => 'B14', 'juros' => true),
                                          'B15' => array('parcelas' => 15, 'codigo' => 'B15', 'juros' => true),
                                          'B16' => array('parcelas' => 16, 'codigo' => 'B16', 'juros' => true),
                                          'B17' => array('parcelas' => 17, 'codigo' => 'B17', 'juros' => true),
                                          'B18' => array('parcelas' => 18, 'codigo' => 'B18', 'juros' => true),
                                          'B19' => array('parcelas' => 19, 'codigo' => 'B19', 'juros' => true),
                                          'B20' => array('parcelas' => 20, 'codigo' => 'B20', 'juros' => true),
                                          'B21' => array('parcelas' => 21, 'codigo' => 'B21', 'juros' => true),
                                          'B22' => array('parcelas' => 22, 'codigo' => 'B22', 'juros' => true),
                                          'B23' => array('parcelas' => 23, 'codigo' => 'B23', 'juros' => true),
                                          'B24' => array('parcelas' => 24, 'codigo' => 'B24', 'juros' => true),
  );
  
  protected static $_errors = array('001' => array('mensagem' => 'Não existe meio de pagamento para o seu pedido.'),
      '002' => array('mensagem' => 'Não existe opção de pagamento para o seu pedido.'),
  );

  /**
   * @param type $paymentMode
   * @return type
   */
  public static function getPaymentMode($paymentMode) {
    if (array_key_exists($paymentMode, self::$_paymentModes)) {
      return self::$_paymentModes[$paymentMode];
    } else {
      throw new Ipagare_IpgPagSeguroDireto_RuntimeException("Chave não encontrada para opção de pagamento informado. Chave = " . $paymentMode);
    }
  }

  /**
   *
   *
   * @param type $error
   * @return
   */
  public static function getError($error) {
    if (array_key_exists($error, self::$_errors)) {
      return self::$_errors[$error];
    } else {
      throw new Ipagare_IpgPagSeguroDireto_RuntimeException("Chave não encontrada o código de erro $error");
    }
  }
}
