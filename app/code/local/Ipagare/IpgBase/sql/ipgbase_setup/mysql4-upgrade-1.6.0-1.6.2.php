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

$installer = $this;

$installer->startSetup();

$conn = $installer->getConnection();
$table = $installer->getTable('sales_flat_order');

if(!$conn->tableColumnExists($table, 'ipagare_order_orig')) {
    $conn->addColumn($table, 'ipagare_order_orig', 'VARCHAR(10) NULL');
}
if(!$conn->tableColumnExists($table, 'ipagare_use_risk_management')) {
    $conn->addColumn($table, 'ipagare_use_risk_management', 'VARCHAR(5) NULL');
}

$installer->endSetup();