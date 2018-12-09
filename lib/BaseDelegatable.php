<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class BaseDelegatable extends BaseClass {

  protected $impl;

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    $this->impl = null;
    $this->setMagicObject($this);

    return $this;
  }

  public function setImpl($impl) {
    $this->impl = $impl;

    return $this;
  }

  public function __call($methodName, $args) {
    if ($this->impl === null) {
      throw new KException("BaseDelegatable::__call(): impl has not been set.");
    }

    $err = method_exists($this->impl, $methodName);
    if (!$err) {
      throw new Exception("BaseDelegatable::__call(): the method " . $methodName . " does not exist to tatget of delegate.");
    }

    // This is a point to change when REST API is used?
    // $result = call_user_method_array($methodName, $this->impl, $args);
    $result = $this->callMethod($methodName, $args);

    return $result;
  }

  protected function callMethod($methodName, $args) {
    $result = call_user_method_array($methodName, $this->impl, $args);

    return $result;
  }

  
  // public function __get($key) {
    /*
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__get(): accessing to getter by this key is not permitted.");
    }

    if ($this->isGetterHookExist($key)) {
      return $this->executeGetterHook($key, $this->retainer[$key]);
    }
    */

    // return $this->impl->retainer[$key];
  // }

}

?>