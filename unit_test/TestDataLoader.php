<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/DB/DataLoader.php");
require_once("lib/KException.php");
require_once("lib/util/Assert.php");

class TestDataLoader extends BaseUnitTest {

  public function test_load() {
    $loader = new DataLoader(); 
    
    $fileName = "../data/test_load.dat";

    $loader->load($fileName);

    // $assert = new Assert();
  }

}