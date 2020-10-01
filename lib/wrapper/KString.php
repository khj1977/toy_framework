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

  public function regex($pattern, $matches = null) {
    if ($matches = null) {
      return preg_match($pattern, $this->internalString);
    }

    $matches = array();
    return preg_match($pattern, $this->internalString, $matches);
  }

}

?>