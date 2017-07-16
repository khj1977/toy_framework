<?php

require_once("lib/BaseDelegatable.php");

class RESTDelegatable extends BaseDelegatable {

  protected function callMethod($methodName, $args) {
    // debug
    // $result = call_user_method_array($methodName, $this->impl, $args);
    // The aboce is the case for method call for the same process of a php.call_user_func
    // For this class, call some REST API and return val.
    // end of debug

    return $result;
  }

}

?>