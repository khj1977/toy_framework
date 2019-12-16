<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");
require_once("lib/KException.php");
require_once("lib/BaseDelegatable.php");

class BaseClass {

  // hash
  protected $accessibles;
  protected $retainer;
  // a user of fw can use both delegatable and delegate on instance val
  // if only for delegatable, there may be a lot of number of config file.
  // but it is difficult to make general purpose delegate such as delegate
  // with REST or Thrift. Therefore, although it is not simple and beautiful, 
  // for practical purpose, both way of
  // of delegate is used.
  protected $delegate;
  protected $magicObject;

  protected $debugStream;
  // yet another name of $debugStream;
  protected $ds;

  // protected $varDump;

  public function __construct() {
    
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    // In practice, the following hash will be overriden by sub class.
    $this->accessibles = array();
    $this->retainer = array();

    $this->delegate = null;
    $this->magicObject = $this;

    // determine delegate by Factory
    // the following is the default code without factory.
    // $factory = TheWorld::instance()->factory();
    // Example:
    // Change context which is second argument of the following method by sub class.
    // Make NullDelegate for default case.
    // $this->delegate = $factory->make("Delegate", "REST")->setClassName($this->getKlassName());

    $this->debugStream = TheWorld::instance()->debugStream;
    $this->ds = TheWorld::instance()->debugStream;

    return $this;
  }

  // $this->delegate or child of BaseDelegate is used, but not BaseDelegatable, because
  // for object composition. It is little bit complex than just inherit BaseDelegatable,
  // but more usable;i.e. inheritance or object composition.
  public function setDelegate($aDelegate) {
    $this->delegate = $aDelegate;

    return $this;
  }

  public function setMagicObject($anObject) {
    $this->magicObject = $anObject;

    return $this;
  }

  public function __call($methodName, $args) {
    if ($this->delegate == null) {
      throw new KException("BaseClass::__call(): method name: " . $methodName . " cannot be resolved.");
    }
    if ($this->delegate->isAcceptThisMethodName($methodName)) {
      return $this->delegate->callMethod($methodName, $args);
    }

    throw new KException("BaseClass::__call(): this method does not implemented on this delegate: " . $methodName);

    // $result = call_uesr_method_array($methodName, $this->delegate, $args);

    $result = $this->delegate->callMethod($medhoName, $args);

    return $result;
  }


  public function setAccessible($key) {
    $this->accessibles[$key] = true;

    return $this;
  }

// debug
  // add validateExistense() for overriding, though it is not used for anytime.
  // end of debug
  public function __set($key, $val) {
    // debug
    // var_dump("__set(): " . $key . " " . $val);
    // var_dump($this->magicObject);
    // end of debug
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__set(): accessing to setter by this key is not permitted: " . $key);
    }

    // there is no problem to call isSetterHookExist() twice considering a cost of 
    // calling method.
    if ($this->isSetterHookExist($key)) {
      return $this->executeSetterHook($key, $this->retainer[$key], $val);
    }

    // var_dump("goo");
    $this->magicObject->retainer[$key] = $val;
    // var_dump($this->magicObject->retainer);

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
      throw new KException("BaseClass::executeSetterHook(): a hook method is not exist with key: " . $key);
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
    // debug
    // var_dump("__get(): " . $key);
    // end of debug
    if (!$this->isValidForProp($key)) {
      throw new KException("BaseClass::__get(): accessing to getter by this key is not permitted: " . $key);
    }

    if ($this->isGetterHookExist($key)) {
      return $this->executeGetterHook($key, $this->retainer[$key]);
    }

    return $this->magicObject->retainer[$key];
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
      throw new KException("BaseClass::executeGetterHook(): a hook method is not exist with key: " . $key);
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

    if (array_key_exists($key, $this->magicObject->getAccessibles())) {
      $err = true;
    }

    return $err;
  }

  protected function getAccessibles() {
    return $this->accessibles;
  }

  protected function isNoRuleForAccessibles() {
  
    $err = false;
    if (count($this->magicObject->getAccessibles()) == 0) {
      $err = true;
    }

    return $err;
  }

  protected function validateExistence() {
    // debug
    // implement this method.
    throw new KException("BaseClass::validateExistense(): this method has not been implemented yet.");
    // end of debug
  }

  protected function getKlassName() {
    return get_class($this);
  }

  public function getPropsAsHash() {
    return $this->retainer;
  }

}

?>