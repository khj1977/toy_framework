<?php

require_once("lib/BaseClass.php");

class KArray extends BaseClass {

  protected $internalArray;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->internalArray = array();
  }

  public function get($index) {

  }

  public function append($string) {

  }

  public function split($delimiter) {

  }

  public function regex($pattern) {

  }

  // return first index of first matched substring with string given.
  public function find($string) {

  }

}

?>