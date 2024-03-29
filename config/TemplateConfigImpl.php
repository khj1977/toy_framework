<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/config/impl/BaseConfigImpl.php");

class DevConfigImpl extends BaseConfigImpl {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // example
    $this->retainer = array(
      "factory_config_path" => $this->baseDir . "/factory_config.csv",
      "db_host" => "127.0.0.1",
      "db_port" => "3306",
      "db_name" => "dev_toy_fw",
      "db_user" => "",
      "db_pass" => ""
    );

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
    // use ordinary while(fgets()) since this is core library
    $lines = "";
    while(trim($line = fgets($stdin))) {
      $lines = $lines . $line;
    }

    return $lines;
  }

}

?>