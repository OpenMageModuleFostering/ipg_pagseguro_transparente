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

class Ipagare_IpgBase_Date {

    protected $day;
    protected $month;
    protected $year;
    protected $hour;
    protected $minute;
    protected $second;
    
    public function __construct($day, $month, $year, $hour, $minute, $second) {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }
    
    public static function getInstanceFormatoAmericano($date){
        $ano = substr($date, 0, 4);
        $mes = substr($date, 5, 2);
        $dia = substr($date, 8, 2);
        $hora = substr($date, 11, 2);
        $minuto = substr($date, 14, 2);
        $segundo = substr($date, 17, 2);
        
        if(Ipagare_IpgBase_Helper_StringUtils::isEmpty($hora)){
            $hora = 0;
        }
        if(Ipagare_IpgBase_Helper_StringUtils::isEmpty($minuto)){
            $minuto = 0;
        }
        if(Ipagare_IpgBase_Helper_StringUtils::isEmpty($segundo)){
            $segundo = 0;
        }
        
        return new Ipagare_IpgBase_Date($dia, $mes, $ano, $hora, $minuto, $segundo);
    }

    public function setDay($day) {
        $this->day = $day;
    }

    public function getDay() {
        return $this->day;
    }

    public function setMonth($month) {
        $this->month = $month;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function getYear() {
        return $this->year;
    }

    public function setHour($hour) {
        $this->hour = $hour;
    }

    public function getHour() {
        return $this->hour;
    }

    public function setMinute($minute) {
        $this->minute = $minute;
    }

    public function getMinute() {
        return $this->minute;
    }

    public function setSecond($second) {
        $this->second = $second;
    }

    public function getSecond() {
        return $this->second;
    }
}

?>
