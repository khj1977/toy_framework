<?php

require_once("BaseClass.php");

abstract class BaseApi extends BaseClass {

  abstract public function __construct();

  // debug
  // $args are basically hash.
  // Or argument object defined by fw. not determined yet.
  // end of debug
  abstract public function call($args);

}

?>