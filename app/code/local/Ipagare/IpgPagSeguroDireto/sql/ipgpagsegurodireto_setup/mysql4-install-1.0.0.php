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

$installer = $this;

$installer->startSetup();

$conn = $installer->getConnection();
$tabelaPagamento = $installer->getTable('ipagare_pagsegurodireto_pagamento');
$tabelaSonda = $installer->getTable('ipagare_pagsegurodireto_sonda');
$tabelaErro = $installer->getTable('ipagare_pagsegurodireto_erro');

$installer->run("
	CREATE TABLE IF NOT EXISTS `{$tabelaPagamento}` (
                `id_ipagare_pagsegurodireto_pagamento` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` VARCHAR(50) NOT NULL default '',
                `meio_pagamento` INT(2) NOT NULL,
                `forma_pagamento` VARCHAR(3) NOT NULL,
                `valor_total` VARCHAR(200) NOT NULL,
                `transaction_code` VARCHAR(50) NOT NULL,
                `payment_link` TEXT NOT NULL,
                `status` VARCHAR(3) NOT NULL,
                `created_time` DATETIME NULL,
                `mensagem_cancelamento` VARCHAR(200) NULL,
		PRIMARY KEY (`id_ipagare_pagsegurodireto_pagamento`)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        CREATE TABLE IF NOT EXISTS `{$tabelaSonda}` (
                `id_ipagare_pagsegurodireto_sonda` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` VARCHAR(50) NOT NULL,
                `register_date` DATETIME NULL,
		PRIMARY KEY (`id_ipagare_pagsegurodireto_sonda`)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        CREATE TABLE IF NOT EXISTS `{$tabelaErro}` (
                `id_ipagare_pagsegurodireto_erro` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` VARCHAR(50) NOT NULL,
                `code` VARCHAR(10) NOT NULL,
		PRIMARY KEY (`id_ipagare_pagsegurodireto_erro`)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$tableSalesOrder = $installer->getTable('sales/order');
$tableQuoteAddress = $installer->getTable('sales/quote_address');
$tableInvoice = $installer->getTable('sales/invoice');

if (!$conn->tableColumnExists($tableSalesOrder, 'ipg_pagsegurodireto_discount_amount')) {
  $conn->addColumn($tableSalesOrder, 'ipg_pagsegurodireto_discount_amount', 'DECIMAL(10,4) NOT NULL');
}
if (!$conn->tableColumnExists($tableSalesOrder, 'ipg_pagsegurodireto_base_discount_amount')) {
  $conn->addColumn($tableSalesOrder, 'ipg_pagsegurodireto_base_discount_amount', 'DECIMAL(10,4) NOT NULL');
}
if (!$conn->tableColumnExists($tableQuoteAddress, 'ipg_pagsegurodireto_discount_amount')) {
  $conn->addColumn($tableQuoteAddress, 'ipg_pagsegurodireto_discount_amount', 'DECIMAL(10,4) NOT NULL');
}
if (!$conn->tableColumnExists($tableQuoteAddress, 'ipg_pagsegurodireto_base_discount_amount')) {
  $conn->addColumn($tableQuoteAddress, 'ipg_pagsegurodireto_base_discount_amount', 'DECIMAL(10,4) NOT NULL');
}
if (!$conn->tableColumnExists($tableInvoice, 'ipg_pagsegurodireto_discount_amount')) {
  $conn->addColumn($tableInvoice, 'ipg_pagsegurodireto_discount_amount', 'DECIMAL(10,4) NOT NULL');
}
if (!$conn->tableColumnExists($tableInvoice, 'ipg_pagsegurodireto_base_discount_amount')) {
  $conn->addColumn($tableInvoice, 'ipg_pagsegurodireto_base_discount_amount', 'DECIMAL(10,4) NOT NULL');
}

$installer->endSetup();
