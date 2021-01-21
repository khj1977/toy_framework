<?php

require_once("lib/BaseClass.php");

class ServerEnv extends BaseClass {
  protected $internalHash;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->internalHash = $_SERVER;

    return $this;
  }

  public function get($key) {
    return $this->internalHash[$key];
  }

  public function check($key) {
    return array_key_exists($key, $this->internalHash);
  }

}

?>