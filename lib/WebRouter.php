<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");
require_once("lib/Util.php");

class WebRouter extends BaseClass {

  protected $webArguments;

  protected $module;
  protected $controller;
  protected $action;

  public function __contruct() {
    parent::__construct();
  }

  public function setWebArguments($webArguments) {
    $this->webArguments = $webArguments;

    return $this;
  }

  public function getRoute() {
    $this->module = urldecode($this->webArguments->get("m"));
    if ($this->module === "") {
      throw new KException("WebRouter::getRoute(): module is not specified.");
    }
    $this->controller = urldecode($this->webArguments->get("c"));
    if ($this->controller === "") {
      throw new KException("WebRouter::getRoute(): controller is not specified.");
    }
    $this->action = urldecode($this->webArguments->get("a"));
    if ($this->module === "") {
      throw new KException("WebRouter::getRoute(): action is not specified.");
    }
    // view is automatically determined by m, c and a.

    $route = array("module" => $this->module, "controller" => $this->controller, "action" => $this->action);

    return $route;
  }

  // return hash
  // "view_path" => string: path of view file.
  // "view_class_name" => string: name of view class.
  public function getView() {
    $viewClassName = Util::ucwords($this->controller) . Util::ucwords($this->action) . "View";

    $this->debugStream->varDump($viewClassName);

    $this->debugStream->varDump(sprintf("%s/apps/%s/views/%s.php", TheWorld::instance()->getBaseDir(), $this->module, $viewClassName));

    $viewPath = Util::realpath(sprintf("%s/apps/%s/views/%s.php", TheWorld::instance()->getBaseDir(), $this->module, $viewClassName));

    return array("view_path" => $viewPath, "view_class_
    name" => $viewClassName);
  }


}

?>