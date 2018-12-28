<?php

require_once("lib/BaseClass.php");

abstract class BaseView extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  abstract public function render();

}

?>