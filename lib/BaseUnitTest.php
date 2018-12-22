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

  public function __construct() {
    parent::__construct();
    // debug
    // initialize TheWorld
    TheWorld::instance()->initialize();
    // end of debug

    $this->theWorld = TheWorld::instance();
    $this->debugStream = $this->theWorld->debugStream;
  }

  public function runTests() {
    try {
      $className = $this->getClassName();
      $instance = new $className();

      $instance->preRun();
      // The following code will invoke actual test defined at sub class of 
      // UnitTest class.
      $testMethodNames = $instance->getTestMethodNames();

      foreach($testMethodNames as $testMethodName) {
        // debug
        // The following should be printed onto stdout or stderr?
        // not so important.
        printf("UnitTest: start to run test: " . $testMethodName . "\n");
        // end of debug
        $instance->$testMethodName();
      }
      $instance->postRun();
    }
    catch(Exception $ex) {
      print("BaseUnitTest error: " . $ex->getMessage() . "\n");
      print("BaseUnitTest error" . $ex->getTraceAsString());

      exit;
    }

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
