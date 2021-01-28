<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

abstract class KSession extends BaseClass {

  protected $suffix;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->suffix = "";

    return $this;
  }

  abstract public function set($key, $val);

  abstract public function get($key);

  abstract public function clear();

  abstract public function getKeys($withSuffix = true);

  public function setWithSuffix($key, $val) {
    $this->setSuffix();
    $this->set($this->suffix . $key, $val);

    return $this;
  }

  public function getWithSuffix($key) {
    $key = $this->suffix . $key;

    return $this->get($key);
  }

  public function generateKeySuffix() {
    return $_SERVER["QUERY_STRING"];
  }

  public function setSuffix($suffix = null) {
    if ($suffix === null) {
      $this->suffix = $this->generateKeySuffix();
    }
    else {
      $this->suffix = $suffix;
    }
    
    return $this;
  }

  public function getSuffix() {
    return $this->suffix;
  }

}

?>