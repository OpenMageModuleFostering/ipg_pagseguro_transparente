<?php

/**
 * Class Ipagare_PagSeguroDireto_Parser_SessionParser
 */
class Ipagare_PagSeguroDireto_Parser_SessionParser extends Ipagare_PagSeguroDireto_Parser_ServiceParser {

  /**
   * @param $str_xml
   * @return Ipagare_PagSeguroDireto_Domain_Session
   */
  public static function readXml($str_xml) {
    $parser = new Ipagare_PagSeguroDireto_Utils_XmlParser($str_xml);
    $data = $parser->getResult('session');

    return new Ipagare_PagSeguroDireto_Domain_Session($data['id']);
  }

}
