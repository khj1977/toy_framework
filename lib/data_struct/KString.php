<?php

require_once("lib/data_struct/KSequential.php");

class KString extends KSequential {

  protected $internalString;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->internalString = "";

    return $this;
  }

  public function append($element) {
    $this->internalString = $this->internalString . $element;

    return $this;
  }

  public function push($element) {
    return $this->append($element);
  }

  public function split($delimiter) {
    $splitted = explode($delimiter, $this->internalString);

    return $splitted;
  }

  // pattern is pattern used for preg_match().
  public function regex($pattern, $matches = null) {
    if ($matches == null) {
      $result = preg_match($pattern, $this->internalString);
      if ($result == 1) {
        return true;
      }

      return false;
    }

    $matches = array();
    preg_match($pattern, $this->internalString, $matches);
    if (count($matches) == 1) {
      throw new KException("KString::regex(): no matches: " . $pattern . " : " . $this->internalString);
    }

    return $matches;
  }

  static public function sregex($str, $pattern, $matches = null) {
    $string = KString::new()->append($str);
    return $string->regex($pattern, $matches);
  }

  public function generator() {
    $len = strlen($this->internalString);
    for($i = 0; $i < $len; ++$i) {
      yield $this->internalString[$i];
    }

    return $this;
  }

  static public function isEqual($str1, $str2) {
    if (strcmp($str1, $str2) === 0) {
      return true;
    }

    return false;
  }

  // debug
  // implement other methods corresponding to demand of other code.
  // end of debug

  public function data() {
    return $this->internalString;
  }

}

?>