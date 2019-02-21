<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/KException.php");

class TestKException extends BaseUnitTest {

  public function test_ex() {
    throw new KException("This is a test message.");
  }

}

?>