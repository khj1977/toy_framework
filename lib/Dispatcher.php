<?php

require_once("lib/BaseClass.php");
require_once("lib/WebRouter.php");
require_once("lib/TheWorld.php");
require_once("lib/KExcception.php");
require_once("lib/WebArguments.php");

class Dispatcher extends BaseClass {

  protected $module;
  protected $controller;
  protected $action;

  public function __construct() {
  }

  public function dispatch() {
    $env = TheWorld::instance()->isCli();
    if ($env === "cli") {
      new KException("cli cannot run by this script.");
    }
    else {
      $arguments = new WebArguments();
      TheWorld::instance()->arguments = $arguments;

      $router = new WebRouter($arguments);
      TheWorld::instance()->router = $router;
    }

    // $arguments = TheWorld::instance()->arguments->getArguments();
    // assume all vals in $route are urldecoded.
    $route = $router->getRoute($arguments);

    $this->module = $route["module"];
    $this->controller = $route["controller"];
    $this->action = $route["action"];

    $basePath = TheWorld::instance()->getBaseDir();
    $controllerPath = $basePath . sprintf("/app/%s/controllers/%sController",
                                          $this->module,
                                          ucwords($this->controller)
      );
    $controllerPath = realpath($controllerPath);
    if ($controllerPath === false) {
      throw new KException("Dispatcher::dispatch(): invalid path: with module and controller" . $this->module . " " . $this->controller);
    }
    require_once($controllerPath);
    $controllerClassName = ucwords($this->controller) . "Controller";
    // debug
    // add checking existence of controller class
    // end of debug
    $controller = new $controllerClassName();

    $actionName = $this->action;

    $result = $controller->$actionName();

    return $result;
  }

  public function getViewPath() {
    $viewPath = $basePath . sprintf("/app/%s/views/%s/%s",
                                          $this->module,
                                          $this->controller,
                                          $this->action
      );

    $realPath = realpath($viewPath);
    if ($realPath === false) {
      throw new Exception("Dispatcher::getViewPath(): invalid path to include view: " . $viewPath);
    }

    return $realPath;
  }

}

?>
