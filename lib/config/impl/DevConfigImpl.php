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
      "db_name" => "dev_toy_fw",
      "db_user" => "",
      "db_pass" => ""
    );

    return $this;
  }

}

?>