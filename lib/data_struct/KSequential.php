<?php

require_once("lib/BaseClass.php");

abstract class KSequential extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function map($f) {
    $klassName = $this->getKlassName();
    $that = new $klassName();

    foreach($this->generator() as $element) {
      $that->push($f($element));
    }

    return $that;
  }

  // naming rule is come from Ruby.
  public function do($f) {
    return $this->map($f);
  }

  public function reduce($f) {
    $result = null;
    foreach($this->generator() as $element) {
      $result = $f($result, $element);
    }

    return $result;
  }

  abstract public function generator();

}

?>