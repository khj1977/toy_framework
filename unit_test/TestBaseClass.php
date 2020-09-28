<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");

class FooModel extends BaseClass {

  public function hook_getter_fooMethod() {
    return "This is foo getter method";
  }

  public function hook_setter_barMethod($arg) {
    print("This is bar setter method.");
  }

}

class TestBaseClass extends BaseUnitTest {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function preRun() {
    $this->debugStream->setFlag(true);
  }

  public function test_getter_hook() {
    $model = new FooModel();
    try {
      $result = $model->fooMethod;
    }
    catch(Exception $ex) {
      TheWorld::instance()->debugStream->varDump(var_dump($ex));
      return false;
    }
    printf("%s", $result);

    return true;
  }

  public function test_setter_hook() {
    $model = new FooModel();
    try {
      $model->barMethod = "apple";
      // debug
      print($result);
      // end of debug
    }
    catch(Exception $ex) {
      TheWorld::instance()->debugStream->varDump(var_dump($ex));
      return false;
    }

    return true;
  }

}

?>