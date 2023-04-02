<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");
require_once("lib/data_struct/KSequential.php");

class KHash extends KSequential {

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
      // throw new KException("Hash::get(): there is no value for key: " . $key);
      return false;
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
      // not yield $val to adapt to the spec of kseq.
      // get($key) will be used to obtain $val. It will be slow even it were O(1).
      // since there is calc of hash code and sometimes, search of binary tree
      // would be done. Since it is not perfect hash.
      yield $key;
    }

    return $this;
  }

  public function len() {
    return count($this->internalArray);
  }

}

?>