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

class Ipagare_IpgPagSeguroDireto_PaymentMode {
    /**
     * à vista
     */
    const A01 = 'A01';

    /**
     * 2x sem juros
     */
    const A02 = 'A02';

    /**
     * 3x sem juros
     */
    const A03 = 'A03';

    /**
     * 4x sem juros
     */
    const A04 = 'A04';

    /**
     * 5x sem juros
     */
    const A05 = 'A05';

    /**
     * 6x sem juros
     */
    const A06 = 'A06';

    /**
     * 7x sem juros
     */
    const A07 = 'A07';

    /**
     * 8x sem juros
     */
    const A08 = 'A08';

    /**
     * 9x sem juros
     */
    const A09 = 'A09';

    /**
     * 10x sem juros
     */
    const A10 = 'A10';

    /**
     * 11x sem juros
     */
    const A11 = 'A11';

    /**
     * 12x sem juros
     */
    const A12 = 'A12';
    
    /**
     * 13x sem juros
     */
    const A13 = 'A13';
    
    /**
     * 14x sem juros
     */
    const A14 = 'A14';
    
    /**
     * 15x sem juros
     */
    const A15 = 'A15';
    
    /**
     * 16x sem juros
     */
    const A16 = 'A16';
    
    /**
     * 17x sem juros
     */
    const A17 = 'A17';
    
    /**
     * 18x sem juros
     */
    const A18 = 'A18';
    
    /**
     * 19x sem juros
     */
    const A19 = 'A19';
    
    /**
     * 20x sem juros
     */
    const A20 = 'A20';
    
    /**
     * 21x sem juros
     */
    const A21 = 'A21';
    
    /**
     * 22x sem juros
     */
    const A22 = 'A22';
    
    /**
     * 23x sem juros
     */
    const A23 = 'A23';
    
    /**
     * 24x sem juros
     */
    const A24 = 'A24';
    
    /**
     * 2x com juros
     */
    const B02 = 'B02';

    /**
     * 3x com juros
     */
    const B03 = 'B03';

    /**
     * 4x com juros
     */
    const B04 = 'B04';

    /**
     * 5x com juros
     */
    const B05 = 'B05';

    /**
     * 6x com juros
     */
    const B06 = 'B06';

    /**
     * 7x com juros
     */
    const B07 = 'B07';

    /**
     * 8x com juros
     */
    const B08 = 'B08';

    /**
     * 9x com juros
     */
    const B09 = 'B09';

    /**
     * 10x com juros
     */
    const B10 = 'B10';

    /**
     * 11x com juros
     */
    const B11 = 'B11';
    
     /**
     * 12x com juros
     */
    const B12 = 'B12';
    
     /**
     * 13x com juros
     */
    const B13 = 'B13';
    
     /**
     * 14x com juros
     */
    const B14 = 'B14';
    
     /**
     * 15x com juros
     */
    const B15 = 'B15';
    
     /**
     * 16x com juros
     */
    const B16 = 'B16';
    
     /**
     * 17x com juros
     */
    const B17 = 'B17';
    
     /**
     * 18x com juros
     */
    const B18 = 'B18';
    
     /**
     * 19x com juros
     */
    const B19 = 'B19';
    
     /**
     * 20x com juros
     */
    const B20 = 'B20';
    
     /**
     * 20x com juros
     */
    const B21 = 'B21';
    
     /**
     * 22x com juros
     */
    const B22 = 'B22';
    
     /**
     * 23x com juros
     */
    const B23 = 'B23';
    
     /**
     * 24x com juros
     */
    const B24 = 'B24';
    
    const SEM_JUROS = "A";

    const AVISTA = "A01";

    private $codigo;
    private $parcelas;
    private $juros;

    public static function getInstance($codigo, $parcelas) {
        if (strlen($parcelas) == 1) {
            $parcelas = '0' . $parcelas;
        }
        return self::valueOf($codigo . $parcelas);
    }

    public static function valueOf($codigo) {
        if (is_null($codigo)) {
            // FIXME: exception
        }
        $p = Ipagare_IpgPagSeguroDireto_Config::getPaymentMode($codigo);
        if (!is_null($p)) {
            $paymentMode = new Ipagare_IpgPagSeguroDireto_PaymentMode();
            $paymentMode->setCodigo($p['codigo']);
            $paymentMode->setParcelas($p['parcelas']);
            $paymentMode->setJuros($p['juros']);

            return $paymentMode;
        }
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setParcelas($parcelas) {
        $this->parcelas = $parcelas;
    }

    public function getParcelas() {
        return $this->parcelas;
    }

    public function setJuros($juros) {
        $this->juros = $juros;
    }

    public function hasJuros() {
        return $this->juros;
    }

    public function isAvista() {
        return $this->codigo == self::A01;
    }

    public function getCompleteName() {
        if ($this->isAvista()) {
            return ' à vista';
        }
        return $this->parcelas . ($this->juros == true ? 'x com juros' : 'x sem juros');
    }
}