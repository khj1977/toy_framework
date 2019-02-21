<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");
require_once("lib/util/Util.php");

class BaseConfigImpl extends BaseClass {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // $this->baseDir = TheWorld::instance()->env->base_dir();
    $this->baseDir = Util::realpath(dirname(__FILE__) . "/../../../");

    return $this;
  }

  // X implement hook for getter
  // define hook required for Config of this stage.

  // For instance, if CSV file is required for config of Factory class, a hook method will load
  // CSV file within hook method not return val using default getter with retainer of 
  // BaseClass.

  // example
  // dummy code
  public function hook_getter_factory_config() {
    $path = $this->factory_config_path;

    $stream = fopen($path, "r");
    if ($stream === false) {
      throw new KException("BaseConfigImpl::hook_getter_factory_config(): file cannot be opened with path: " . $path);
    }

    // use ordinary while(fgets()) since this is core library
    trim($line = fgets($stream));
    fclose($line);

    return $line;
  }

}

?>