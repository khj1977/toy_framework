<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");

// debug
// check whether there is exception handler for each test.
// end of debug
abstract class BaseUnitTest extends BaseClass {

  const testMethodPrefix = "test";
  const testMethodSplitChar = "_";

  protected $theWorld;
  protected $debugStream;

  protected $currentTestMethodName;
  protected $numSuccess;
  protected $numFail;
  protected $numTests;

  public function __construct() {
    // print("bar29");
    parent::__construct();
    // debug
    // initialize TheWorld
    TheWorld::instance()->initialize();
    // TheWorld::instance()->debugStream->varDump("goo20");
    // end of debug

    $this->theWorld = TheWorld::instance();
    $this->debugStream = $this->theWorld->debugStream;

    return $this;
  }

  public function runTests() {
    $this->numSuccess = 0;
    // debug
    // var_dump("foo");
    // end of debug
    $this->numFail = 0;
    $this->numTests = 0;
    try {
      $className = $this->getClassName();
      $instance = new $className();

      $instance->preRun();
      // The following code will invoke actual test defined at sub class of 
      // UnitTest class.
      $testMethodNames = $instance->getTestMethodNames();

      /*
      $this->numSuccess = 0;
      // debug
      // var_dump("foo");
      // end of debug
      $this->numFail = 0;
      $this->numTests = 0;
      */
      foreach($testMethodNames as $testMethodName) {
        // debug
        // The following should be printed onto stdout or stderr?
        // not so important.
        printf("UnitTest: start to run test: " . $testMethodName . "\n");
        $instance->incNumTests();
        $this->currentTestMethodName = $testMethodName;
        // end of debug
        // debug
        try {
          $result = $instance->$testMethodName();
        }
        catch(Exception $e) {
          $result = false;
        }
        // end of debug
        if ($result === true) {
          printf("Succeeded: " . $testMethodName . "\n");
          // var_dump("loop1: " . $this->numTests . " " . $this->numSuccess);
          // $this->numSuccess = $this->numSuccess + 1;
          $instance->incNumSuccess();
          // var_dump("loop2: " . $this->numTests . " " . $this->numSuccess);
        }
        else if ($result === false) {
          printf("Failed: " . $testMethodName . "\n");
          // $this->numFail = $this->numFail + 1;
          $instance->incNumFail();
        }

        // var_dump("loop: " . $this->numTests . " " . $this->numSuccess);
      }
      $instance->postRun();
    }
    catch(Exception $ex) {
      print("BaseUnitTest error: " . $ex->getMessage() . "\n");
      print("BaseUnitTest error" . $ex->getTraceAsString());

      // debug
      // Is it valid considering scope of val?
      // Not sure that there is scope of val in a method.
      $instance->incNumFail();
      // end of debug



      exit;
    }

    printf("Total Tests %d; Success %d; Fail %d\n", $instance->getNumTests(), $instance->getNumSuccess(), $instance->getNumFail());

    // debug
    // var_dump($instance);
    // var_dump($this);
    // end of debug

    return $this;
  }

  public function setFailed() {
    printf("Failed: " . $this->currenTestMethodName . "\n");
    $this->numFail = $this->numFail + 1;

    // debug
    // var_dump($this);
    // end of debug

    return $this;
  }

  public function setSuccessed() {
    // printf("Succeeded: " . $this->currentTestMethodName . "\n");
    $this->numSuccess = $this->numSuccess + 1;

     // debug
     // var_dump("num succes 1 : " . $this->numSuccess);
     // var_dump($this);
     // end of debug

    return $this;
  }

  public function getNumTests() {
    return $this->numTests;
  }

  public function getNumSuccess() {
    return $this->numSuccess;
  }

  public function getNumFail() {
    return $this->numFail;
  }

  public function incNumTests() {
    $this->numTests = $this->numTests + 1;

    return $this;
  }

  public function incNumSuccess() {
    $this->numSuccess = $this->numSuccess + 1;

    return $this;
  }

  public function incNumFail() {
    $this->numFail = $this->numFail + 1;

    return $this;
  }

  protected function preRun() {
    // Do nothing for base class.
  }

  protected function postRun() {
    // Do nothing for base class.
  }

  protected function getTestMethodNames() {
    $testMethodNames = array();

    $testMethodPattern = sprintf("/^%s%s/", BaseUnitTest::testMethodPrefix, BaseUnitTest::testMethodSplitChar);
    $allMethodNames = $this->getMethodNames();
    // foreach($allMethodNames as $methodName) {
    foreach($allMethodNames as $reflectionMethod) {
      $methodName = $reflectionMethod->name;

      $err = preg_match($testMethodPattern, $methodName);
      if ($err != 1) {
        continue;
      }

      $testMethodNames[] = $methodName;
    }

    return $testMethodNames;
  }

  protected function getMethodNames() {
    $klass = new ReflectionClass($this->getClassName());
    $methods = $klass->getMethods();

    return $methods;
  }

  protected function getClassName() {
    return get_class($this);
  }

}

?>
