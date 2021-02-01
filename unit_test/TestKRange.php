<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/util/KRange.php");
require_once("lib/util/Util.php");

class TestKRange extends BaseUnitTest {

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

  public function test_range() {
    KRange::new()->set(0, 10, 1)->each(function($k) {
      Util::println("each: " . $k);
    });

    return true;
  }

  public function test_rangeAsObject() {
    $obj = KRange::new()->set(100, 110, 2);

    $obj->each(function($j) {
      Util::println("obj: " . $j);
    });
  }

}