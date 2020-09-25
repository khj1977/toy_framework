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

  protected function isAcceptThisMethodName($methodName) {
    $err = method_exists($this->target, $methodName);
    if (!$err) {
      return false;
    }

    return true;
  }

  protected function callMethod($methodName, $args) {
    // debug
    // replace by call_user_func_array
    // $result = call_user_func_array(array($this->impl, $methodName), $args);

    // debug
    // the following is the original
    // $result = call_user_method_array($methodName, $this->target, $args);
    // end of debug

    $result = call_user_func_array(array($this->target, $methodName), $args);
    // end of debug

    return $result;
  }

}

?>