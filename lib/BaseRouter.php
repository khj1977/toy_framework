<?php

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

abstract class BaseRouter extends BaseClass {

  public function __construct() {

  }

  abstract public function exec($url);

}

?>