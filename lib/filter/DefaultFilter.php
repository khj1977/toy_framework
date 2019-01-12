<?php

require_once("lib/BaseClass.php");

class DefaultFilter extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function apply($val) {
    // Default filter do nothing.
    return $val;
  }

}

?>