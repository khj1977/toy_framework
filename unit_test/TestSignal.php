<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");
require_once("lib/sys/KSignal.php");

class TestSignal extends BaseUnitTest {

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

  public function test_elementary() {
    $signal = new KSignal();

    $signal->addHandler(2, function(){print("Hello from sig");});

    while(true) {
    }

    return;
  }

}

  ?>