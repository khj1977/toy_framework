<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/config/BaseConfig.php");

class Config extends BaseConfig {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function getDBProps() {
    /*
    $this->retainer = array(
      "factory_config_path" => $this->baseDir . "/factory_config.csv",
      "db_host" => "127.0.0.1",
      "db_name" => "dev_toy_fw",
      "db_user" => "root",
      "db_pass" => "root"
    );
    */
    
    $dbProps = array("host" => $this->db_host, "name" => $this->db_name,
      "user" => $this->db_user, "pass" => $this->db_pass);

    return $dbProps;
  }

}

?>