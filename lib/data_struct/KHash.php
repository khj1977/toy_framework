<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class KHash extends BaseClass {

  protected $internalArray;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function initialize() {
    parent::initialize();

    $this->internalArray = array();

    return $this;
  }

  public function get($key) {
    if (!$this->check($key)) {
      throw new KException("Hash::get(): there is no value for key: " . $key);
    }

    return $this->internalArray[$key];
  }

  public function check($key) {
    return array_key_exists($key, $this->internalArray);
  }

  public function set($key, $val) {
    $this->internalArray[$key] = $val;

    return $this;
  }

  public function bulkSet($rawHash) {
    foreach($rawHash as $key => $val) {
      $this->set($key, $val);
    }

    return $this;
  }

  public function generator() {
    foreach($this->internalArray as $key => $val) {
      yield $key => $val;
    }

    return $this;
  }

}

?>