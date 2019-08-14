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

class Ipagare_IpgBase_Helper_LogUtils {

    public static function varDump($variable) {
        $logFile = Mage::getBaseDir('var') . DS . 'log' . DS . Mage::getStoreConfig('dev/log/file');
        ob_start();
        // write content
        if (is_object($variable)) {
            //new Ipagare_Print($variable);
              var_dump($variable);
        } else {
            var_dump($variable);
        }
        $content = ob_get_contents();
        ob_end_clean();
        file_put_contents($logFile, $content, FILE_APPEND);
    }

}

class Ipagare_Print {

    public function __construct($class) {
        $api = new ReflectionClass($class);

        foreach ($api->getProperties() as $propertie) {
            print $propertie->getName() . "\n";
            print $propertie->getValue($class);
        }
        
        
    }
    
    

}