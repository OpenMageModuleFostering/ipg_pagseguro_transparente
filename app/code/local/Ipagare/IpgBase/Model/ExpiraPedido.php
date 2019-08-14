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

class Ipagare_IpgBase_Model_ExpiraPedido extends Mage_Core_Model_Abstract {

    private $logger;

    /**
     * Initialize resource model
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    public function buscaPedidosParaExpirar() {
        $dataInicialBuscaPedidos = $this->getDataInicial();
        $dataCriacaoMaxima = $this->getDataExpiracao();
        $metodosPagamento = $this->buildPaymentMethods();
        $orderIds = array();
        $resource = Mage::getSingleton('core/resource');

        $sql = "SELECT increment_id FROM {$resource->getTableName('sales_flat_order')} o 
                INNER JOIN {$resource->getTableName('sales_flat_order_payment')} p ON p.parent_id=o.entity_id";
        $sql .= ' WHERE o.state=\'' . Mage_Sales_Model_Order::STATE_NEW . '\'';
        $sql .= ' and o.created_at BETWEEN \'' . $dataInicialBuscaPedidos . '\' and \'' . $dataCriacaoMaxima . '\'';
        $sql .= ' AND (p.method = \'\' OR p.method IS NULL)';
        
        $readConnection = $resource->getConnection('core_read');
        $tmp = $readConnection->fetchAll($sql);
        if (is_array($tmp)) {
            $orderIds = array_merge($orderIds, $tmp);
        }

        // módulo Core integração direta de pagamento
        if (Mage::helper('ipgbase/module')->isCoreExists()) {
            $tmp = Mage::getModel('ipgcore/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima, $metodosPagamento);
            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }

        // módulo Moip
        if (Mage::helper('ipgbase/module')->isMoipExistsAndActive()) {
            $tmp = Mage::getModel('ipgmoip/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima);

            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }

        // módulo Pagamento Digital
        if (Mage::helper('ipgbase/module')->isPagamentoDigitalExistsAndActive()) {
            $tmp = Mage::getModel('ipgpagamentodigital/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima);

            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }

        // módulo PagSeguro
        if (Mage::helper('ipgbase/module')->isPagSeguroExistsAndActive()) {
            $tmp = Mage::getModel('ipgpagseguro/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima);
            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }

        // módulo IpgCobreBemAprovaFacil
        if (Mage::helper('ipgbase/module')->isCobreBemAprovaFacilExistsAndActive()) {
            $tmp = Mage::getModel('ipgcobrebemaprovafacil/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima);
            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }

        // módulo IpgPagSeguroLightbox
        if (Mage::helper('ipgbase/module')->isPagSeguroLightboxExistsAndActive()) {
            $tmp = Mage::getModel('ipgpagsegurolightbox/expiraPedido')->buscaPedidosParaExpirar($sql, $dataInicialBuscaPedidos, $dataCriacaoMaxima);
            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }
        
        // módulo IpgPagSeguroDireto
        if (Mage::helper('ipgbase/module')->isPagSeguroDiretoExistsAndActive()) {
            $tmp = Mage::getModel('ipgpagsegurodireto/expiraPedido')->buscaPedidosParaExpirar($dataInicialBuscaPedidos, $dataCriacaoMaxima);
            if (is_array($tmp)) {
                $orderIds = array_merge($orderIds, $tmp);
            }
        }
        
        return $orderIds;
    }

    public function cancelaPedido(Mage_Sales_Model_Order $order) {
        $paymentMethod = $order->getPayment()->getMethodInstance()->getCode();
        $listPaymentMethodsIpagare = Mage::helper('ipgbase')->listPaymentMethods();
        $this->logger->info('Processando cancelamento do pedido ' . $order->getRealOrderId() . ', do modulo: ' . $paymentMethod);

        try {
            if ($order->getState() != Mage_Sales_Model_Order::STATE_CANCELED) {
                $order->cancel();

                //força o cancelamento
                if ($order->getStatus() != Mage_Sales_Model_Order::STATE_CANCELED) {
                    $order->setState(
                            Mage_Sales_Model_Order::STATE_CANCELED, true, Mage::helper('ipgbase')->__('Pedido cancelado'), $notified = false
                    );
                } else {
                    $order->addStatusToHistory($order->getStatus(), Mage::helper('ipgbase')->__('Pedido cancelado.'));
                }

                if ($order->hasInvoices() != '') {
                    $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true, Mage::helper('ipgbase')->__('O pagamento e o pedido foram cancelados, mas não foi possível retornar os produtos ao estoque pois já havia uma fatura gerada para este pedido.'), $notified = false);
                }
                $order->save();
            }

            if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isCoreExists() && $paymentMethod == $listPaymentMethodsIpagare[0]) {
                Mage::getModel('ipgcore/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isMoipExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[1]) {
                Mage::getModel('ipgmoip/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isPagamentoDigitalExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[2]) {
                Mage::getModel('ipgpagamentodigital/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isPagSeguroExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[3]) {
                Mage::getModel('ipgpagseguro/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isCobreBemAprovaFacilExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[4]) {
                Mage::getModel('ipgcobrebemaprovafacil/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isPagSeguroLightboxExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[5]) {
                Mage::getModel('ipgpagsegurolightbox/notification')->sendEmail($order);
            } else if (Mage::helper('ipgbase')->isIpagarePaymentMethod($paymentMethod) && Mage::helper('ipgbase/module')->isPagSeguroDiretoExistsAndActive() && $paymentMethod == $listPaymentMethodsIpagare[6]) {
                Mage::getModel('ipgpagsegurodireto/notification')->sendEmail($order);
            }
        } catch (Exception $e) {
            $this->logger->error("Erro ao cancelar pedido $orderId \n $e->__toString()");
        }

        $this->logger->info('Cancelamento do pedido foi concluido ' . $order->getRealOrderId() . ', do modulo: ' . $paymentMethod);

        return;
    }

    public function isExpiracaoAtiva() {
        return Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::EXPIRACAO_PEDIDO_ACTIVE);
    }

    private function getDataInicial() {
        return Mage::helper('ipgbase/date')->convertDateToBr(Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::EXPIRACAO_PEDIDO_DATA_INICIAL));
    }

    public function getDataExpiracao() {
        $dias = Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::EXPIRACAO_PEDIDO_PERIODO_DIAS);
        $horas = Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::EXPIRACAO_PEDIDO_PERIODO_HORAS);
        $minutos = Mage::getStoreConfig(Ipagare_IpgBase_ConfiguracoesSystem::EXPIRACAO_PEDIDO_PERIODO_MINUTOS);

        $order = Mage::getModel('sales/order');
        $data = $order->getResource()->formatDate(mktime());

        $data = Mage::helper('ipgbase/date')->addMinutesToUs(-$minutos, $data);
        $data = Mage::helper('ipgbase/date')->addHoursToUs(-$horas, $data);
        $data = Mage::helper('ipgbase/date ')->addDaysToUs(-$dias, $data);

        return $data;
    }

    private function buildPaymentMethods() {
        $paymentMethods = Mage::helper('ipgbase')->listPaymentMethods();
        $methods = '';
        if ($paymentMethods != null) {
            for ($i = 0; $i < sizeof($paymentMethods); $i++) {
                $methods .= '\'' . $paymentMethods[$i] . '\'';
                if (($i + 1) < sizeof($paymentMethods)) {
                    $methods .= ',';
                }
            }
        }
        return $methods;
    }

}
