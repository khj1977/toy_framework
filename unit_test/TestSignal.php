<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");
require_once("lib/sys/KSignal.php");

declare(ticks = 1);

function test_hello($sigNo, $sigInfo) {
  print("Hello!!!\n");
  exit();
}

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

    $signal->addHandler(SIGHUP, function(){print("\nHello from sig\n");});

    posix_kill(posix_getpid(), SIGHUP);

    return;
  }

  /*
  public function test_coreSignal() {
    print(SIGHUP . "\n");
    var_dump(pcntl_signal_get_handler(SIGHUP));

    $f = function() {print("Hello Anon Func!!\n"); exit;};
    $err = pcntl_signal(SIGHUP, $f);
    print("sig err: " . $err . "\n");
    if ($err == TRUE) {
      print("OK\n");
    }

    print("end\n");

    posix_kill(posix_getpid(), SIGHUP);
  }
  */

}

  ?>