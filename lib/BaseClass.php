<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");
require_once("lib/UException.php");

class BaseClass {

  // hash
  protected $accessibles;
  protected $retainer;

  public function __construct() {
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    // In practice, the following hash will be overriden by sub class.
    $this->accessibles = array();
    $this->retainer = array();

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

    // there is no problem to call isSetterHookExist() twice considering a cost of 
    // calling method.
    if ($this->isSetterHookExist($key)) {
      return $this->executeSetterHook($key, $this->retainer[$key], $val);
    }

    $this->retainer[$key] = $val;
    return $this;
  }

  protected function isSetterHookExist($key) {
    // naming rule of hook method.
    // hook_setter_$key

    $methodName = $this->makeSetterHookMethodName($key);

    $err = method_exists($this->getKlassName(), $methodName);
    if (!$err) {
      return false;
    }

    return true;
  }

  protected function executeSetterHook($key, $oldVal, $val) {
    if ($this->isSetterHookExist($key)) {
      throw new UException("BaseClass::executeSetterHook(): a hook method is not exist with key: " . $key);
    }

    $methodName = $this->makeSetterHookMethodName($key);

    $result = call_user_method_array($methodName, $this->getKlassName(), array($key, $oldVal, $val));

    return $result;
  }

  protected function makeSetterHookMethodName($key) {
    $methodName = sprintf("hook_setter_%s", $key);

    return $methodName;
  }

  // debug
  // add validateExistense()
  // end of debug
  public function __get($key) {
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__get(): accessing to getter by this key is not permitted.");
    }

    if ($this->isGetterHookExist($key)) {
      return $this->executeGetterHook($key, $this->retainer[$key]);
    }

    return $this->retainer[$key];
  }

  protected function isGetterHookExist($key) {
    $methodName = $this->makeSetterHookMethodName($key);

    $err = method_exists($this->getKlassName(), $methodName);
    if (!$err) {
      return false;
    }

    return true;
  }

  protected function executeGetterHook($key) {
    if ($this->isGetterHookExist($key)) {
      throw new UException("BaseClass::executeGetterHook(): a hook method is not exist with key: " . $key);
    }

    $methodName = $this->makeGetterHookMethodName($key);

    $result = call_user_method_array($methodName, $this->getKlassName(), array($key));

    return $result;
  }

  protected function makeGetterHookMethodName($key) {
    $methodName = sprintf("hook_getter_%s", $key);

    return $methodName;
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

  protected function getKlassName() {
    return get_class($this);
  }

}

?>