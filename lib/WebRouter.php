<?php

require_once("lib/BaseClass.php");

class WebRouter extends BaseClass {

  public function __contruct() {
    parent::__construct();
  }

  public function getRouter($getArguments) {
    $module = urldecode($getArguments["m"]);
    $controller = urldecode($getArguments["c"]);
    $action = urldecode($getArguments["a"]);
    // view is automatically determined by m, c and a.

    $route = array("module" => $module, "controller" => $controller, "action" => $action);

    return $route;
  }


}

?>