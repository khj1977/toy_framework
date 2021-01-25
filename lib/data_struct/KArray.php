<?php

require_once("lib/KException.php");
require_once("lib/data_struct/KSequential.php");

class KArray extends KSequential {

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

  public function bulkSet($rawArray) {
    foreach($rawArray as $element) {
      $this->append($element);
    }

    return $this;
  }

  public function push($element) {
    return $this->append($element);
  }

  public function bulkPush($rawArray) {
    return $this->bulkSet($rawArray);
  }

  public function generator() {
    foreach($this->internalArray as $element) {
      yield $element;
    }

    return true;
  }

}

?>