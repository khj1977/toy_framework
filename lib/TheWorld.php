<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSSErrorHandler.php");
require_once("lib/config/Config.php");
require_once("lib/DB/MyPdo.php");

class TheWorld {

  static protected $instance = null;
  // protected $rssErrorHandler;
  protected $internalRetainer;

  // hash
  protected $args;

  // Will hold something like the following as instance value.
  // protected $stdin;
  // protected $stderror
  // protected $stdout;

  static public function instance() {
    if (TheWorld::$instance === null) {
      TheWorld::$instance = new TheWorld();
    }

    return TheWorld::$instance;
  }

  protected function __construct() {
    // $this->initialize();

    return $this;
  }

  public function setArgs($args) {
    // $this->args = $args;
    $this->internalRetainer["args"] = $args;

    return $this;
  }

  public function initialize() {
    $this->setErrorHandler();
    $this->rssErrorHandler = new RSSErrorHandler();

    $this->internalRetainer = array();

    $this->initializeInternalRetainer();

    $this->config = new Config();
    // debug
    // change to set "dev" by env val by apache or something like that.
    $this->config->setStage("Dev");
    // end of debug

    $dbProps = $this->config->getDBProps();

    $pdo = new MyPdo($dbProps);
    $this->master = $pdo;
    // debug
    // refactor to check master and slave is the same or not and make new object, etc.
    $this->slave = $pdo;
    // end of debug

    return $this;
  }

  protected function initializeInternalRetainer() {
    $this->internalRetainer["rssErrorHandler"] = new RSSErrorHandler();
  
    return $this;
  }

  public function setErrorHandler() {
    /*
    set_error_handler(function($errorNo, $errorStr) {
        $message = sprintf("TheWorld::setErrorHandler(): %d\t%s", $errorNo, $errorStr);
        throw new Exception($message);
      } );
    */

    return $this;
  }

  public function __get($key) {
    if (array_key_exists($key, $this->retainer)) {
      return $this->internalRetainer[$key];
    }

    return false;
  }

  public function getSlave() {
    return $this->slave;
  }

  public function getMaster() {
    return $this->master;
  }

  public function getBaseDir() {
    return realpath(dirname(__FILE__) . "/../");
  }

}

?>
