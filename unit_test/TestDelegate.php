<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/BaseDelegate.php");
require_once("lib/BaseClass.php");

class TargetClass {
  public function say() {
    echo "Hello\n";

    return $this;
  }

  public function bye() {
    echo "Good Bye\n";

    return $this;
  }
}

class AClass extends BaseClass {

}

class TestDelegate extends BaseUnitTest {

  public function test_delegate_make() {
    $targetObject = new TargetClass();
    $delegate = new BaseDelegate();
    $delegate->setTarget($targetObject);

    $aClass = new AClass();
    $aClass->setDelegate($delegate);

    $aClass->say()->bye();

    return true;
  }

}

?>