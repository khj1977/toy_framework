<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class BaseDelegate extends BaseClass {

  protected $target;

  public function __construct() {
    parent::__construct();
    
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    $this->target = null;

    return $this;
  }

  public function setTarget($target) {
    $this->target = $target;

    return $this;
  }

  public function __call($methodName, $args) {
    if ($this->target === null) {
      throw new UException("BaseDelegatable::__call(): target has not been set.");
    }

    $err = method_exists($this->target, $methodName);
    if (!$err) {
      throw new UException("BaseDelegatable::__call(): the method " . $methodName . " does not exist to tatget of delegate.");
    }

    // This is a point to change when REST API is used?
    $result = call_user_method_array($methodName, $this->target, $args);

    return $result;
  }

  protected function isAcceptThisMethodName() {
    $err = method_exists($this->target, $methodName);
    if (!$err) {
      return false;
    }

    return true;
  }

  protected function callMethod($methodName, $args) {
    $result = call_user_method_array($methodName, $this->target, $args);

    return $result;
  }

}

?>