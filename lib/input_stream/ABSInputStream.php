<?php

require_once("lib/BaseClass.php");

abstract class ABSInputStream extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  abstract public function next();

  abstract public function getItem();


}

?>