<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Util.php");

class TestRealPath extends BaseUnitTest {

  public function test_utilRealPath() {
    $path = Util::realpath(__FILE__ . "/../../../../foo.php" );
    $this->debugStream->varDump($path);

    return true;
  }

}

?>