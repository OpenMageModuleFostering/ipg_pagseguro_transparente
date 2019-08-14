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

Mage::helper('ipgpagsegurodireto')->getPagSeguroLibrary();

class Ipagare_IpgPagSeguroDireto_Model_Sonda extends Mage_Core_Model_Abstract {

  const MAX_SONDA_PERIOD_DAYS = 10;

  private $logger;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    parent::_construct();
    $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
  }

  protected function getNotification() {
    return Mage::getModel('ipgpagsegurodireto/notification');
  }

  public function criarSonda($orderId) {
    if (empty($orderId)) {
      $this->logger->info("Não foi possivel criar a sonda. Número do pedido não foi encontrado.");
      return false;
    }
    $this->logger->info("Criacao de sonda para o pedido : $orderId");
    try {
      $payment = Mage::getModel('ipgpagsegurodireto/entity_sonda');
      $payment->loadByAttribute('order_id', $orderId);

      if ($payment->getOrderId() == '') {
        $payment->setOrderId($orderId);
        $payment->setDueDate(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));
        $payment->setRegisterDate(date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));
        $payment->save();
      }
    } catch (Exception $e) {
      $this->logger->error("Erro ao Criar a sonda do pedido $orderId \n Verificar a tabela ipagare_pagsegurodireto_sonda . \n" . $e->__toString());
    }
  }

  public function removerSonda($orderId) {
    $this->logger->info("Removendo sonda do pedido: $orderId");

    $resource = Mage::getSingleton('core/resource');
    try {
      $installer = new Mage_Core_Model_Resource_Setup('core_setup');
      $installer->startSetup();

      $sql = "DELETE FROM `{$resource->getTableName('ipagare_pagsegurodireto_sonda')}` WHERE `order_id`=$orderId;";

      $installer->run($sql);
      $installer->endSetup();
    } catch (exception $e) {
      $this->logger->error("Erro ao excluir sonda do pedido: $orderId");
    }
  }

  public function atualizarPagamento(Mage_Sales_Model_Order $order, Ipagare_PagSeguroDireto_Domain_Transaction $transaction) {
    $transactionStatus = $transaction->getStatus();
    $valorPago = $order->getBaseGrandTotal();

    if (($transactionStatus->isPaga() || $transactionStatus->isDisponivel())) {
      $this->atualizarTabelaIpagarePagSeguro($order, $transaction);

      if ($order->getState() == Mage_Sales_Model_Order::STATE_NEW) {
        $this->getNotification()->processSuccess($order->getRealOrderId(), $valorPago, $transactionStatus->getMessage());
      }
      $this->removerSonda($order->getRealOrderId());
    } else if ($transactionStatus->isAguardandoPagamento() || $transactionStatus->isEmAnalise()) {
      $this->atualizarTabelaIpagarePagSeguro($order, $transaction);
      if ($this->deveLogarResultadoSonda($order->getRealOrderId())) {
        $this->getNotification()->addStatusHistoryComment($order, $transactionStatus->getMessage());
      }
    } else if (($transactionStatus->isCancelada() || $transactionStatus->isDevolvida())) {
      $this->atualizarTabelaIpagarePagSeguro($order, $transaction);

      if (!$order->isCanceled()) {
        $msgSourceCancelamento = 'Pedido ' . $order->getRealOrderId() . ': ';

        switch ($transaction->getCancellationSource()) {
          case 'INTERNAL':
            $msgSourceCancelamento .= 'A transação foi cancelada pelo PagSeguro sem ter sido finalizada.';
            break;

          case 'EXTERNAL':
            $msgSourceCancelamento .= 'A transação foi cancelado pelo Banco Emissor ou Operadora do Cartão sem ter sido finalizada.';
            break;

          default:
            $msgSourceCancelamento .= 'A transação foi cancelada sem ter sido finalizada.';
            break;
        }
        $this->getNotification()->processCancel($order->getRealOrderId(), $msgSourceCancelamento);
      }
      $this->removerSonda($order->getRealOrderId());
    } else {
      $this->logger->info('Status de pagamento do pedido [' . $order->getRealOrderId() . '] nao foi alterado.');
      return false;
    }

    $this->logger->info('Status de pagamento do pedido ' . $order->getRealOrderId() . ' foi alterado.');
    return true;
  }

  private function deveLogarResultadoSonda($orderId) {
    $paymentSonda = $this->getEntityPayment($orderId);
    $diffHours = $this->diffDate($paymentSonda->getRegisterDate());
    if ($diffHours >= 1) {
      return false;
    }
    return true;
  }

  /*
   * Calcula a diferença em horas entre uma data e outra.
   */

  private function diffDate($dataInicial) {
    $ano = substr($dataInicial, 0, 4);
    $mes = substr($dataInicial, 5, 2);
    $dia = substr($dataInicial, 8, 2);
    $hora = substr($dataInicial, 11, 2);
    $minuto = substr($dataInicial, 14, 2);
    $segundo = substr($dataInicial, 17, 2);

    $data = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
    $now = time();

    $difMinutes = ($now - $data) / 60; // minutos
    $difHours = $difMinutes / 60; // horas

    return $difHours;
  }

  public function atualizarTabelaIpagarePagSeguro(Mage_Sales_Model_Order $order, Ipagare_PagSeguroDireto_Domain_Transaction $transaction) {
    $payment = $this->getEntityPayment($order->getRealOrderId());
    $payment->setOrderId($transaction->getReference());
    $payment->setMeioPagamento($transaction->getPaymentMethod()->getCode()->getValue());
    //$payment->setFormaPagamento($transaction->getPaymentMethod());
    $payment->setValorTotal($transaction->getGrossAmount());
    $payment->setTransactionCode($transaction->getCode());
    $payment->setStatus($transaction->getStatus()->getCode());
    $payment->setPaymentLink($payment->getPaymentLink());
    //$payment->setCreatedTime($payment->getCreatedTime());
    $payment->save();

    return true;
  }

  public function getOrderIds() {
    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $sql = "SELECT `order_id` FROM `{$resource->getTableName('ipagare_pagsegurodireto_sonda')}` ";
    $orderIds = $readConnection->fetchAll($sql);

    return $orderIds;
  }

  public function run($orderId) {
    $order = Mage::getModel('sales/order')->loadByAttribute('increment_id', $orderId);
    $paymentSonda = $this->getEntityPayment($orderId);
    $transactionSearchResponse = null;

    if ($paymentSonda != null) {
      // verifica se deve excluir sonda
      if ($this->deveExcluirSonda($paymentSonda->getCreatedTime())) {
        $this->logger->info('Removendo sonda para pedido: ' . $orderId);
        $this->removerSonda($orderId);
        return true;
      }
      $this->logger->info('Executando sonda para pedido: ' . $orderId);

      $credentials = Mage::getSingleton('ipgpagsegurodireto/credential')->getAccountCredentials();
      $transactionSearchService = new Ipagare_PagSeguroDireto_Service_TransactionSearchService();
      $transactionSearchResponse = $transactionSearchService->searchByCode($credentials, $paymentSonda->getTransactionCode());

      if ($transactionSearchResponse->hasErrors()) {
        foreach ($transactionSearchResponse->getErrors() as $error) {
          $this->logger->error('Erro ao executar sonda. Pedido [' . $orderId . ']. Erro [' . $error->getCode() . ' - ' . $error->getMessage() . ']');
        }

        return $transactionSearchResponse;
      }

      $transaction = $transactionSearchResponse->getTransaction();
      if ($order->getRealOrderId()) {
        $grossAmount = round($transaction->getGrossAmount(), 2);
        $baseGrandTotal = round($order->getBaseGrandTotal(), 2);

        if ($grossAmount != $baseGrandTotal) {
          $msg = "Total pago ao PagSeguro ({$grossAmount}) é diferente do valor original ({$baseGrandTotal}). Pedido:" . $orderId;
          $order->addStatusToHistory($order->getStatus(), Mage::helper('ipgpagsegurodireto')->__($msg), true);
          $order->save();
          $this->logger->info($msg);
        }

        $this->atualizarPagamento($order, $transaction);
      } else {
        $this->logger->info('Pedido [' . $orderId . '] não localizado na loja.');
        $this->removerSonda($orderId);
      }
    } else {
      $this->logger->info('Não foi possivel encontrar o pedido na base de dados de pagamento. Pedido: ' . $orderId);
      $this->removerSonda($orderId);
    }

    return $transactionSearchResponse;
  }

  public function getEntityPayment($orderId) {
    try {
      $pagamento = Mage::getModel('ipgpagsegurodireto/entity_payment');
      $pagamento->loadByAttribute('order_id', $orderId);
      if ($pagamento->getOrderId() != '') {
        return $pagamento;
      }
    } catch (Exception $e) {
      $this->logger->error("Erro ao abrir a sonda do pedido $orderId \n  Verificar a tabela ipagare_pagsegurodireto_sonda . \n $e->__toString()");
    }

    return false;
  }

  private function deveExcluirSonda($dataRegistro) {
    $dataExpiracao = Mage::helper('ipgbase/date')->addDaysToUs(self::MAX_SONDA_PERIOD_DAYS, $dataRegistro);

    if (Mage::helper('ipgbase/date')->isUsDateBeforeToday($dataExpiracao)) {
      return true;
    }

    return false;
  }

}
