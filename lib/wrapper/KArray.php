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
    return $this->internalArray[$index];
  }

  public function append($element) {
    $this->internalArray[] = $element;

    return $this;
  }

}

?>