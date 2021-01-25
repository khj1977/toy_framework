<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");
require_once("lib/data_struct/KHash.php");
require_once("lib/util/Util.php");

class TestKHash extends BaseUnitTest {

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

  public function test_set() {
    $aHash = KHash::new();
    $aHash->set("fruit", "apple");

    foreach($aHash->generator() as $key => $val) {
      Util::println("set: " . $key . " : " . $val);
    }

    return true;
  }

  public function test_bulkSet() {
    $aHash = KHash::new()->bulkSet(array("name" => "Jim", "age" => 25, "place" => "New York"));

    foreach($aHash->generator() as $key => $val) {
      Util::println("bulk: " . $key . " : " . $val);
    }

    return true;
  }

}
?>