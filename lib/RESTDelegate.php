<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegate.php");

// debug
// implement this class
// end of debug

class RESTDelegate extends BaseDelegate {

  protected function callMethod($methodName, $args) {
    // debug
    // $result = call_user_method_array($methodName, $this->targe, $args);
    // The above is the case for method call for the same process of a php.call_user_func
    // For this class, call some REST API and return val.
    // end of debug

    return $result;
  }

}

?>