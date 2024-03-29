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

  protected $observes;

  // Not that using prototype pattern is experimental issue. Thus, it could be deleted in
  // a future.
  // Checking Self, author thinks it is very interesting technique of design and impl,
  // though author knows JavaScript. If it were live computing environment,
  // dynmical change of behviour of class library would be better choise. However,
  // if it were biz system, class base or prototype base, which is better?
  protected $prototype;

  protected $debugStream;
  // yet another name of $debugStream;
  protected $ds;
  protected $hds;

  // protected $varDump;

  public function __construct() {
    
    $this->initialize();

    return $this;
  }

  static public function new() {
    $klassName = get_called_class();

    $that = new $klassName();

    return $that;
  }

  protected function initialize() {
    // In practice, the following hash will be overriden by sub class.
    $this->accessibles = array();
    $this->retainer = array();

    $this->delegate = null;
    $this->magicObject = $this;

    $this->observes = array();

    // determine delegate by Factory
    // the following is the default code without factory.
    // $factory = TheWorld::instance()->factory();
    // Example:
    // Change context which is second argument of the following method by sub class.
    // Make NullDelegate for default case.
    // $this->delegate = $factory->make("Delegate", "REST")->setClassName($this->getKlassName());

    $this->debugStream = TheWorld::instance()->debugStream;
    $this->ds = TheWorld::instance()->debugStream;
    $this->hds = TheWorld::instance()->htmlDebugStream;

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

    $result = $this->delegate->callMethod($methodName, $args);

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
      return $this->executeSetterHook($this->makeSetterHookMethodName($key),
      $this->retainer[$key], $val);
    }

    $this->magicObject->retainer[$key] = $val;

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

    // $methodName = $this->makeSetterHookMethodName($key);
    $methodName = $key;

    // debug
    // replace by call_user_func_array
    // return call_user_func_array(array($this, $hookMethodName), array($propName => $val));
    // $result = call_user_method_array($methodName, $this->getKlassName(), array($key, $oldVal, $val));
    $result = call_user_func_array(array($this, $methodName), array($key, $oldVal, $val));
    // end of debug

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
      return $this->executeGetterHook($this->makeGetterHookMethodName($key),
       $this->retainer[$key]);
    }

    return $this->magicObject->retainer[$key];
  }

  protected function isGetterHookExist($key) {
    // $methodName = $this->makeSetterHookMethodName($key);
    $methodName = $this->makeGetterHookMethodName($key);

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

    $methodName = $key;
    // $methodName = $this->makeGetterHookMethodName($key);

    // debug
    // replace by call_user_func_array
    // $result = call_user_method_array($methodName, $this->getKlassName(), array($key));
    $result = call_user_func_array(array($this, $methodName), array($key));
    // end of debug

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

  public function getKlassName() {
    return get_class($this);
  }

  public function getPropsAsHash() {
    return $this->retainer;
  }

  // debug
  // implement the following method
  public function clone() {
    throw new KException("BaseClass::clone(): this method has not been implemented yet.");
  }
  // end of debug

  // Impl of prototype may similar to delegate.
  // However, those are slightly different idea
  // debug
  // implement the following method
  public function setPrototype($prototype) {
    throw new KException("BaseClass::setPrototype(): this method has not been implemented yet.");
  }
  // end of debug

  public function addObserve($obj) {
    $this->observes[] = $obj;

    return $this;
  }

  protected function changed() {
    foreach($this->observes as $obj) {
      $obj->fire();
    }

    return $this;
  }

  protected function fire() {
    return $this->changed();
  }

}

?>