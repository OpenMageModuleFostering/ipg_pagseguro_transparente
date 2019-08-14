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

class Ipagare_IpgBase_Model_Observer {

    private $logger;

    const ACTION_MARCAR = 'marcar';
    const ACTION_CAPTURAR = 'capturar';
    const ACTION_CANCELAR = 'cancelar';

    /**
     * Initialize resource model
     */
    public function __construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
    }

    public function expirapedido() {
        $this->logger->info('Executando expiração automática de pedidos - início');

        if (Mage::getModel('ipgbase/expiraPedido')->isExpiracaoAtiva()) {
            $orderIds = Mage::getModel('ipgbase/expiraPedido')->buscaPedidosParaExpirar();
            foreach ($orderIds as $key => $value) {
                $order = Mage::getModel('sales/order');
                $order = $order->loadByAttribute('increment_id', $value['increment_id']);
                // verifica se pedido não está cancelado
                if ($order->getState() != Mage_Sales_Model_Order::STATE_CANCELED) {
                    $this->logger->info('Vai expirar pedido ' . $value['increment_id']);
                    Mage::getModel('ipgbase/expiraPedido')->cancelaPedido($order);
                }
            }
        } else {
            $this->logger->info('Expiração automática não está ativa, não irá expirar nenhum pedido.');
        }

        $this->logger->info('Executando expiração automática de pedidos - fim');
    }

    public function expiraBoletos() {
        $this->logger->info('Executando expiração automática de boletos - início');

        //core

        if (Mage::helper('ipgbase/module')->isCoreExists()) {
            $orderIds = Mage::getModel('ipgcore/expiraBoletos')->expiraBoletos();
            foreach ($orderIds as $key => $value) {
                $this->expirarOrder($value['order_id']);
            }
        }

        //moip

        if (Mage::helper('ipgbase/module')->isMoipExistsAndActive()) {
            $realOrderIds = Mage::getModel('ipgmoip/expiraBoletos')->expiraBoletos();
            foreach ($realOrderIds as $key => $value) {
                $this->expirarOrder($value['real_order_id']);
            }
        }

        //CobreBem
        if (Mage::helper('ipgbase/module')->isCobreBemAprovaFacilExistsAndActive()) {
            $realOrderIds = Mage::getModel('ipgcobrebemaprovafacil/expiraBoletos')->expiraBoletos();
            foreach ($realOrderIds as $key => $value) {
                $this->expirarOrder($value['order_increment_id']);
            }
        }

        $this->logger->info('Executando expiração automática de boletos - fim');
    }

    public function expirarOrder($orderId) {
        $this->logger->info('Vai expirar boleto ' . $orderId);
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        if ($order) {
            Mage::getModel('ipgbase/expiraPedido')->cancelaPedido($order);
        }
    }

    public function enviaEmailBoletosAvencer() {
        //core
        if (Mage::helper('ipgbase/module')->isCoreExists()) {
            $realOrderIds = Mage::getModel('ipgcore/observer')->enviaEmailPedidoBoleto();
        }

        //moip
        if (Mage::helper('ipgbase/module')->isMoipExistsAndActive()) {
            $realOrderIds = Mage::getModel('ipgmoip/observer')->enviaEmailPedidoBoleto();
        }

        //cobrebem
        if (Mage::helper('ipgbase/module')->isCobreBemAprovaFacilExistsAndActive()) {
            $realOrderIds = Mage::getModel('ipgcobrebemaprovafacil/observer')->enviaEmailPedidoBoleto();
        }
    }

    public function logUserAction($observer) {
        $orderId = $observer->getEvent()->getOrderId();
        $action = $observer->getEvent()->getAction();
        $comment = '';
        if (Mage::app()->getStore()->isAdmin() && Mage::getSingleton('admin/session')->getUser() != null) {
            $user = Mage::getSingleton('admin/session')->getUser()->getName();
            if ($action == self::ACTION_MARCAR) {
                $comment = "Usuário $user marcou boleto do pedido $orderId como pago";
            } elseif ($action == self::ACTION_CAPTURAR) {
                $comment = "Usuário $user capturou pagamento do pedido $orderId";
            } elseif ($action == self::ACTION_CANCELAR) {
                $comment = "Usuário $user cancelou pagamento do pedido $orderId";
            }
        } else {
            $comment = 'Pedido atualizado automaticamente';
        }

        $this->logger->info($comment);
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        Mage::helper('ipgbase')->addStatusHistoryComment($order, $comment);
    }

    public function licenseExpCheck() {
        $this->logger->info('Executando verificação da licença iPAGARE - início');
        if (extension_loaded('ionCube Loader')) {
            $ioncubeInfo = ioncube_file_info();
            if (isset($ioncubeInfo['FILE_EXPIRY'])) {
                $licenseExpDay = $ioncubeInfo['FILE_EXPIRY'];
                $remainingDays = abs(floor((time() - $licenseExpDay) / 86400));
                if ($remainingDays == 14 || $remainingDays == 7 || $remainingDays == 1) {
                    if ($remainingDays == 14) {
                        $title = 'ATENÇÃO: A licença iPAGARE vai expirar em duas semanas! Contate nosso suporte para renovar.';
                        $description = 'A licença iPAGARE da sua loja vai expirar em duas semanas. Contate nosso <a href="http://ajuda.ipagare.com.br" target="_blank">suporte</a> para renovar.';
                        $severity = Mage_AdminNotification_Model_Inbox::SEVERITY_MINOR;
                        $this->logger->info('Faltam duas semanas para a expiração da licença iPAGARE');
                    }
                    if ($remainingDays == 7) {
                        $title = 'ATENÇÃO: A licença iPAGARE vai expirar em uma semana! Contate nosso suporte para renovar.';
                        $description = 'A licença iPAGARE da sua loja vai expirar em uma semana. Contate nosso <a href="http://ajuda.ipagare.com.br" target="_blank">suporte</a> para renovar.';
                        $severity = Mage_AdminNotification_Model_Inbox::SEVERITY_MAJOR;
                        $this->logger->info('Falta uma semana para a expiração da licença iPAGARE');
                    }
                    if ($remainingDays == 1) {
                        $title = 'ATENÇÃO: A licença iPAGARE vai expirar amanhã! Contate nosso suporte para renovar.';
                        $description = 'A licença iPAGARE da sua loja vai expirar amanhã. Contate nosso <a href="http://ajuda.ipagare.com.br" target="_blank">suporte</a> para renovar.';
                        $severity = Mage_AdminNotification_Model_Inbox::SEVERITY_CRITICAL;
                        $this->logger->info('Falta 1 dia para a expiração da licença iPAGARE');
                    }
                    $inbox = Mage::getModel('adminnotification/inbox');
                    $url = 'http://ajuda.ipagare.com.br';
                    $isInternal = false;
                    $inbox->add($severity, $title, $description, $url, $isInternal);
                }
            }
        }
        $this->logger->info('Executando verificação da licença iPAGARE - fim');
    }

}