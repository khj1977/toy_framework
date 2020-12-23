<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class KArray extends BaseClass {

  protected $internalArray;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->internalArray = array();

    return $this;
  }

  public function get($index) {
    $len = count($this->internalArray);
    if (($len - 1) < $index) {
      throw new KException("KArray::get(): out of bound. length of array is: " . $len);
    }

    return $this->internalArray[$index];
  }

  public function set($index, $val) {
    $this->internalArray[$index] = $val;

    return $this;
  }

  public function append($element) {
    $this->internalArray[] = $element;

    return $this;
  }

  public function generator() {
    foreach($this->internalArray as $element) {
      yield $element;
    }

    return true;
  }

}

?>