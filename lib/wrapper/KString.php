<?php

class KString extends BaseClass {

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
    $this->internalString . $element;

    return $this;
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

  // debug
  // implement other methods corresponding to demand of other code.
  // end of debug

}

?>