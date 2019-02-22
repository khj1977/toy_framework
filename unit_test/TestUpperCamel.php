<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Util.php");
require_once("lib/util/Assert.php");

class TestUpperCamel extends BaseUnitTest {

  public function test_testUpper() {
    $str = "foo_bar_goo";
    $result = Util::upperCamelToUnderScore($str);

    $this->debugStream->varDump($result);

    $assert = new Assert();
    $err = $assert->stringEqual("FooBarGoo", $result);

    $this->debugStream->varDump($err);

    return $err;
  }

}

?>