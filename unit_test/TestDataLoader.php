<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/DB/DataLoader.php");
require_once("lib/KException.php");
require_once("lib/util/Assert.php");

class TestDataLoader extends BaseUnitTest {

  public function test_load() {
    $loader = new DataLoader(); 
    // debug
    // add file name
    throw new KException("file name should be assigned");
    $fileName = "";
    // end of debug

    $loader->load($fileName);

    // $assert = new Assert();
  }

}