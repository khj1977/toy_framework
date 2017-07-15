<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSSErrorHandler.php");

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

  static public function getInstance() {
    if (TheWorld::$instance === null) {
      TheWorld::$instance = new TheWorld();
    }

    return TheWorld::$instance;
  }

  protected function __construct() {
    $this->initialize();

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

    print("foo\n");

    return $this;
  }

  public function __get($key) {
    if (array_key_exists($key, $this->retainer)) {
      return $this->internalRetainer[$key];
    }

    return false;
  }

  public function getSlave() {
    // debug
    // implement this method.
    throw new Exception("TheWorld::getSlave(): this method has not been implemented yet.");
    // end of debug
  }

  public function getMaster() {
    // debug
    // implement this method
    throw new Exception("TheWorld::getMaster(): this method has not been implemented yet.");
    // end of debug
  }

}

?>
