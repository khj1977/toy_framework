<?php

require_once("lib/Util/KSession.php");

class SimpleSession extends KSession {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function set($key, $val) {
    $oldKey = $key;
    if ($this->suffix != "") {
      $key = $this->suffix . $key;
    }

    $_SESSION[$key] = array("real_val" => $val,"real_key" => $oldKey);

    return $this;
  }

  public function get($key) {
    if (!array_key_exists($key, $_SESSION)) {
      return false;
    }

    return $_SESSION[$key];
  }

  public function hasKey($key) {
    return array_key_exists($key, $_SESSION);
  }

  public function getKeys($withSuffix = true) {
    $keys = array();
    foreach($_SESSION as $key => $val) {
      if ($withSuffix) {
        $matched = array();
        if (preg_match("/^" . $this->suffix . "(.*)/", $key, $matched) == 0) {
          continue;
        }
      }

      $keys[] = $key;
    }

    return $keys;
  }

}

?>