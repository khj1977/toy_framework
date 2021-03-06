<?php

set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));
// require_once(dirname(__FILE__) . "/../lib/BaseBatch.php");
// require_once(dirname(__FILE__) . "/../lib/TheWorld.php");
require_once(dirname(__FILE__) . "/../lib/BaseBatch.php");
require_once(dirname(__FILE__) . "/../lib/TheWorld.php");


class UnitTestBatch extends BaseBatch {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function xmain($args) {
    $testName = "Test" . $args[1];
    $unitTestPhpFileName = $testName . ".php";

    $basePath = TheWorld::instance()->getBaseDir();
    $unitTestPath = Util::realpath($basePath . "/unit_test/" . $unitTestPhpFileName);
    // debug
    // add checking file existense of unit test php file.
    // end of debug
    
    require_once($unitTestPath);
    $object = new $testName();
    $object->runTests();

    return $this;
  }

}

if (count($argv) != 2) {
  printf("usage: php UnitTestBatch.php test_name¥n");
  exit(-1);
}

$testObject = new UnitTestBatch();
try {
  $testObject->run($argv);
}
catch(Exception $e) {
  printf("UnitTestBatch: error: " . $e->getMessage());
}

return 1;

?>