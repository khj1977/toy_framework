<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class WebRouter extends BaseClass {

  public function __contruct() {
    parent::__construct();
  }

  public function getRoute($webArguments) {
    $module = urldecode($webArguments->get("m"));
    if ($module === "") {
      throw new KException("WebRouter::getRoute(): module is not specified.");
    }
    $controller = urldecode($webArguments->get("c"));
    if ($controller === "") {
      throw new KException("WebRouter::getRoute(): controller is not specified.");
    }
    $action = urldecode($webArguments->get("a"));
    if ($module === "") {
      throw new KException("WebRouter::getRoute(): action is not specified.");
    }
    // view is automatically determined by m, c and a.

    $route = array("module" => $module, "controller" => $controller, "action" => $action);

    return $route;
  }


}

?>