<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/KException.php");
require_once("lib/util/Util.php");;

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
    $this->controller = Util::upperCamelToUnderScore(urldecode($this->webArguments->get("c")));
    if ($this->controller === "") {
      throw new KException("WebRouter::getRoute(): controller is not specified.");
    }
    $this->action = Util::upperCamelToUnderScore(urldecode($this->webArguments->get("a")));
    if ($this->action === "") {
      throw new KException("WebRouter::getRoute(): action is not specified.");
    }

    $outputHandlerName = $this->webArguments->get("o");
    if ($outputHandlerName === false) {
      // throw new KException("WebRouter::getRoute(): action is not specified.");
      $this->outputHandler = null;
    }
    else {
      $this->outputHandler = Util::upperCamelToUnderScore(urldecode($outputHandlerName));
    }
 
    // view is automatically determined by m, c and a.

    $route = array("module" => $this->module, "controller" => $this->controller, "action" => $this->action);

    return $route;
  }

  public function hasOutputHandler() {
    if ($this->outputHandler === null) {
      return false;
    }

    return true;
  }

  public function getScaffoldView() {
    // not changed with respect to action but
    // only by controller. Note that this can
    // be changed by other controller or
    // strategy if required (not implemented).
    // $viewClassName = sprintf("%sScaffoldView",  ucwords($this->controller));

    $viewClassName = sprintf("ScaffoldDefaultViewTemplate",  ucwords($this->controller));

    $viewPath = Util::realpath(sprintf("%s/lib/scaffold/view_template/%s.php", TheWorld::instance()->getBaseDir(), $viewClassName));

    return array(
      "view_path" => $viewPath, 
      "view_class_name" => $viewClassName,
      // debug
      // refactor the following css specification.
      "default_css_path" => "/css/style.css"
      // end of debug
    );
  }

  // return hash
  // "view_path" => string: path of view file.
  // "view_class_name" => string: name of view class.
  public function getView($controller) {
    if ($controller->isScaffold()) {
      return $this->getScaffoldView();
    }

    $viewClassName = Util::ucwords($this->controller) . Util::ucwords($this->action) . "View";

    $this->debugStream->varDump($viewClassName);

    $this->debugStream->varDump(sprintf("%s/apps/%s/views/%s.php", TheWorld::instance()->getBaseDir(), $this->module, $viewClassName));

    $viewPath = Util::realpath(sprintf("%s/apps/%s/views/%s.php", TheWorld::instance()->getBaseDir(), $this->module, $viewClassName));

    return array("view_path" => $viewPath, "view_class_name" => $viewClassName);
  }

  public function getModule() {
    return $this->module;
  }

  public function getController() {
    return $this->controller;
  }

  public function getAction() {
    return $this->action;
  }

}

?>