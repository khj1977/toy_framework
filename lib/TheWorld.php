<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSSErrorHandler.php");
require_once("lib/config/Config.php");
require_once("lib/DB/MyPdo.php");
require_once("lib/stream/DebugStream.php");
require_once("lib/stream/HTMLDebugStream.php");
require_once("lib/util/KLogger.php");
require_once("lib/util/SimpleSession.php");
require_once("lib/util/ServerEnv.php");
require_once("lib/view/RenderingArea.php");

class TheWorld {

  static protected $instance = null;
  // protected $rssErrorHandler;
  protected $internalRetainer;

  // hash
  protected $args;

  protected $isCli;

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

  public function destruct() {
    $this->logger->close();

    return $this;
  }

  public function isCli() {
    return $this->isCli;
  }

  public function setIsCli() {
    $this->isCli = true;
  }

  public function setArgs($args) {
    // $this->args = $args;
    $this->internalRetainer["args"] = $args;

    return $this;
  }

  public function initialize() {

    static $initialized = false;
    if ($initialized === true) {
      return $this;
    }

    // debug
    // refactor the following line.
    $this->isCli = false;
    // end of debug

    date_default_timezone_set("UTC");

    $this->setErrorHandler();
    $this->rssErrorHandler = new RSSErrorHandler();

    $this->internalRetainer = array();

    $this->initializeInternalRetainer();

    $this->config = new Config();

    $this->serverEnv = new ServerEnv();
    $this->stage = $this->serverEnv->get("K_STAGE");
    $this->config->setStage($this->stage);
    $this->debugStream = new DebugStream($this->stage);
    $this->htmlDebugStream = new HTMLDebugStream($this->stage);

    $dbProps = $this->config->getDBProps();

    $pdo = new MyPdo($dbProps);
    $this->master = $pdo;
    // debug
    // refactor to check master and slave is the same or not and make new object, etc.
    $this->slave = $pdo;
    // end of debug

    $this->logger = new KLogger($this->htmlDebugStream);

    $this->session = new SimpleSession();

    $this->renderingArea = new RenderingArea();

    $this->setErrorHandler();

    // debug
    // $this->bar();
    // end of debug

    /*
    set_error_handler(function($errorNo, $errorStr) {
      $message = sprintf("TheWorld::initialize(): %d\t%s", $errorNo, $errorStr);

      // not to use KException to avoid diverted call of Excetpion and framework component since this is initialization stage of the framework.
      // throw new Exception($message);
      // print("foo<br>");
    } );
    */

    $initialized = true;

    return $this;
  }

  protected function initializeInternalRetainer() {
    $this->internalRetainer["rssErrorHandler"] = new RSSErrorHandler();
  
    return $this;
  }

  public function setErrorHandler() {
    set_error_handler(function($errorNo, $errorStr) {
        $message = sprintf("TheWorld::setErrorHandler(): %d\t%s", $errorNo, $errorStr);
        throw new Exception($message);
      } );

    return $this;
  }

  public function __get($key) {
    if (array_key_exists($key, $this->internalRetainer)) {
      return $this->internalRetainer[$key];
    }

    return false;
  }

  public function __set($key, $val) {
    $this->internalRetainer[$key] = $val;
    
    return $this;
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
