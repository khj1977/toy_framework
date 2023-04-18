<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

// Execution function to set up require_once dir.
require_once("lib/TheWorld.php");
require_once("lib/BaseErrorHandler.php");
// require_once("lib/BaseClass.php");

abstract class BaseBatch {

  protected $args;
  // The followings will be handled by TheWorld.
  // protected $stdin;
  // protected $stdout;
  // protected $stderr;

  public function __construct() {
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    // $this->initialize();
    TheWorld::instance()->initialize();
    TheWorld::instance()->setIsCli();

    // TheWorld::instance()->debugStream->varDump("goo10");

    return $this;
  }


  final public function run($args) {
    $baseErrorHandler = new BaseErrorHandler();
    try {
      $this->xmain($args);
    }
    catch(Exception $ex) {
      $baseErrorHandler->handleError($ex);
      exit;
    }

    return true;
  }

  abstract protected function xmain($args);

}

?>
