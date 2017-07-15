<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");

class BaseClass {

  // hash
  protected $accessibles;

  public function __construct() {
    // In practice, the following hash will be overriden by sub class.
    $this->accessibles = array();

    return $this;
  }

  public function setAccessible($key) {
    $this->accessibles[$key] = true;

    return $this;
  }

// debug
  // add validateExistense() for overriding, though it is not used for anytime.
  // end of debug
  public function __set($key, $val) {
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__set(): accessing to setter by this key is not permitted.");
    }

    $this->retainer[$key] = $val;
    return $this;
  }

  // debug
  // add validateExistense()
  // end of debug
  public function __get($key) {
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__get(): accessing to getter by this key is not permitted.");
    }

    return $this->retainer[$key];
  }

  protected function isValidForProp($key) {
    $err = false;
    if ($this->isNoRuleForAccessibles() || $this->isAccessible($key)) {
      $err = true;
    }

    return $err;
  }

  protected function isAccessible($key) {
    $err = false;

    if (array_key_exists($key, $this->accessibles)) {
      $err = true;
    }

    return $err;
  }

  protected function isNoRuleForAccessibles() {
    $err = false;
    if (count($this->accessibles) == 0) {
      $err = true;
    }

    return $err;
  }

  protected function validateExistence() {
    // debug
    // implement this method.
    throw new Exception("BaseClass::validateExistense(): this method has not been implemented yet.");
    // end of debug
  }

}

?>