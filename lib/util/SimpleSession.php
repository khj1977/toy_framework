<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/Util/KSession.php");
require_once("lib/util/Util.php");

class SimpleSession extends KSession {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function start() {
    session_start();

    return $this;
  }

  public function set($key, $val) {
    $oldKey = $key;
    if ($this->suffix != "") {
      $key = $this->suffix . $key;
    }

    $_SESSION[$key] = array("real_val" => Util::serialize($val),"real_key" => $oldKey);

    return $this;
  }

  public function get($key) {
    if (!array_key_exists($key, $_SESSION)) {
      return false;
    }

    if (Util::isEmpty($_SESSION[$key])) {
      return false;
    }

    $val = $_SESSION[$key];

    return array("real_key" => $val["real_key"], "real_val" => Util::unserialize($val["real_val"]));
  }

  public function hasKey($key) {
    if (array_key_exists($key, $_SESSION)) {
      $val = $_SESSION[$key];
      $val = $val["real_val"];
      $val = Util::unserialize($val);
      if ($val === false || $val === null || $val === "") {
        return false;
      }
      else {
        return true;
      }
    }
    
    return false;
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