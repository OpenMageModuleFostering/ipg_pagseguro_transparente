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

class Ipagare_IpgPagSeguroDireto_Model_ExpiraPedido extends Mage_Core_Model_Abstract {

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  public function buscaPedidosParaExpirar($dataInicialBuscaPedidos, $dataCriacaoMaxima) {
    $resource = Mage::getSingleton('core/resource');
    $sql = "SELECT increment_id FROM {$resource->getTableName('sales_flat_order')} o 
                INNER JOIN {$resource->getTableName('ipagare_pagsegurodireto_pagamento')} ip ON ip.order_id = o.increment_id";
    $sql .= ' WHERE o.state=\'' . Mage_Sales_Model_Order::STATE_NEW . '\'';
    $sql .= ' and o.created_at BETWEEN \'' . $dataInicialBuscaPedidos . '\' and \'' . $dataCriacaoMaxima . '\'';

    $readConnection = $resource->getConnection('core_read');
    $orderIds = $readConnection->fetchAll($sql);

    return $orderIds;
  }

}
