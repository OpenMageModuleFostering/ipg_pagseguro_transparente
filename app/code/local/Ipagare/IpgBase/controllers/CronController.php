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

class Ipagare_IpgBase_CronController extends Mage_Core_Controller_Front_Action {

    private $logger;

    /**
     * Instantiate config
     */
    protected function _construct() {
        $this->logger = Ipagare_IpgBase_Logger::getLogger(__CLASS__);
        parent::_construct();
    }

    public function indexAction() {
        $status = 'OK';
        $this->logger->info('Cron - Início');
        try {
            Mage::app('admin')->setUseSessionInUrl(false);
            Mage::getConfig()->init()->loadEventObservers('crontab');
            Mage::app()->addEventArea('crontab');
            Mage::dispatchEvent('default');
        } catch (Exception $e) {
            $status = $e->getMessage();
            $this->logger->error($e->getMessage() . "\n\n" . $e->getTraceAsString());
        }
        $this->logger->info('Cron - Fim');

        $this->getResponse()->setBody($status);
    }

}