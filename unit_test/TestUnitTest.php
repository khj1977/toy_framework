<?php

require_once("lib/BaseUnitTest.php");

class TestUnitTest extends BaseUnitTest {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function test_exception() {
    try {
      // forcefully count error by exception may cause error becauseit will lost what is $this.
      throw new Exception("This is error");

      $this->setSuccessed();
    }
    catch(Exception $e) {
      $this->setFailed();
    }

    // debug
    // var_dump("out loop: " . $this->numSuccess);
    // end of debug

    // return true;
  }

  public function test_exception2() {
    try {
      // throw new Exception("This is error");

      $this->setSuccessed();
    }
    catch(Exception $e) {
      $this->setFailed();
    }

    // debug
    // var_dump("out loop 2: " . $this->numSuccess);
    // end of debug
  }

}

?>