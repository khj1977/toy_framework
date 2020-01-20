<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

// ugry. Refactor this.
require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/util/AnonClass.php");

class TestAssert extends BaseUnitTest {

  protected function preRun() {
    $this->debugStream->setFlag(false);
  }

  public function test_AssertEqual() {
    $foo = 1;

    $assert = new Assert();
    return $assert->equal(1, $foo);
  }

  public function test_AssertObject() {
    $foo = AnonClass::makeObjectByHash(
      array("prop1" => 1, "prop2" => 2)
    );

    $bar = AnonClass::makeObjectByHash(
      array(
        "prop1" => 1,
        "prop2" => 2
      )
    );

    $assert = new Assert();
    return $assert->objectEqual($foo, $bar);
  }

}