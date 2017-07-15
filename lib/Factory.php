<?php

require_once("lib/TheWorld.php");
require_once("lib/UException.php");

// This is Factory class for general purpose. This generalization will be realized by
// using config file which define class to make including class name, path, and possibly 
// argument to construct instance of that class.

// Config class is used for config of this class. Note that that config class is not 
// depends on this class, though it uses DI and possibly Factory pattern.

// Format of this config file is as follows:
// kind,subclass,param1,param2,param3,param4,...
// Note that this config is actually handled by Config of this framework and which is coded
// with in impl of config class (possibly by here document).
class Factory {

  protected $config;

  public function __construct() {
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    $this->config = $this->getConfigOfThisClass();

    return $this;
  }

  // $kind: to specify base class of target to make.
  // $context: practically, which specify parameters depending config file.
  // It could be said this is just a tag or parameter of config file.
  public function make($kind, $context) {
    try {
      // $configOfKind is an array.
      $configOfKind = $this->config[$context];
    }
    catch(UException $e) {
      $theWorld = TheWorld::instance();
      $loggerMessage = "Factory::make()". $e->getMessage();
      $theWorld->logger->log($theWorld->const->logger_warn, $loggerMessage);

      throw new UException($loggerMessage);
    }

    $subClass = $configOfKind[0];
    $remainingParam = array();

    $len = count($configOfKind);
    for($i = 1; $i < ($len - 1); ++$i) {
      $remainingParam[] = $configOfKind[$i];
    }

    $instance = $this->xmake($subClass, $remainingParam);

    return $instance;
  }

  // $kind: to specify base class of target to make.
  // $param is a scalar or an object.
  // $remainingPram is a hash.
  protected function xmake($class, $param) {
    $instance = new $class();
    $instance->applyConstructorParam($param);

    return $instance;
  }

  protected function getConfigOfThisClass() {
    $config = TheWorld::instance()->getConfig();

    // $config->config_factory is wrapper of a hash or an object which inherit BaseClass
    // whose key is $context which is used in make() of 
    // this class.

    // debug
    // add key exist varidation to getter of BaseClass
    // end of debug
    return $config->config_factory;
  }

}

?>