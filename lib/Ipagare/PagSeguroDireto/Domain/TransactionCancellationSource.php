<?php

class Ipagare_PagSeguroDireto_Domain_TransactionCancellationSource {

  private static $sourceList = array(
      'INTERNAL' => 'PagSeguro',
      'EXTERNAL' => 'Instituições Financeiras'
  );
  private $value;

  public function __construct($value = null) {
    if ($value) {
      $this->value = $value;
    }
  }

  public function setValue($value) {
    $this->value = $value;
  }

  public function setByType($type) {
    if (isset(self::$sourceList[$type])) {
      $this->value = self::$sourceList[$type];
    } else {
      throw new Exception("undefined index $type");
    }
  }

  public function getValue() {
    return $this->value;
  }

  /**
   * @param string $value
   * @return string the transaction type corresponding to the informed type value value
   */
  public function getTypeFromValue($value = null) {
    $value = ($value == null ? $this->value : $value);
    return array_search($value, self::$sourceList);
  }

}
