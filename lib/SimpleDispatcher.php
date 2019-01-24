<?php

require_once("lib/BaseClass.php");
require_once("lib/WebRouter.php");
require_once("lib/TheWorld.php");
require_once("lib/KException.php");
require_once("lib/WebArguments.php");

class SimpleDispatcher extends BaseClass {

  protected $module;
  protected $controller;
  protected $action;

  public function __construct() {
    parent::__construct();
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

    session_start();

    // $arguments = TheWorld::instance()->arguments->getArguments();
    // assume all vals in $route are urldecoded.
    $route = $router->setWebArguments($arguments)->getRoute();

    $this->module = $route["module"];
    $this->controller = $route["controller"];
    $this->action = $route["action"];

    $theWorld = TheWorld::instance();
    $theWorld->moduleName = $this->module;
    $theWorld->controllerName = $this->controller;
    $theWorld->actionName = $this->action;

    $basePath = TheWorld::instance()->getBaseDir();
    $controllerPath = $basePath . 
      sprintf(
        "/apps/%s/controllers/%sController.php",
        $this->module,
        ucwords($this->controller)
      );

    $controllerPath = realpath($controllerPath);
    if ($controllerPath === false) {
      throw new KException("Dispatcher::dispatch(): invalid path: with module and controller: module: " . $this->module . " controller: " . $this->controller);
    }
    require_once($controllerPath);
    $controllerClassName = ucwords($this->controller) . "Controller";
    // debug 
    // add checking existence of controller class. And if not there, throw exception.
    // end of debug
    $controller = new $controllerClassName();

    $actionName = $this->action;

    try {
      $controller->preAction();
      $subView = $controller->$actionName();
      $controller->postAction();

      $viewVals = $router->getView();

      // debug
      $this->debugStream->varDump("debug");
      $this->debugStream->varDump($viewVals);
      // end of debug

      require_once($viewVals["view_path"]);
    }
    catch(KException $e) {
      $message = "Dispatcher: " . $e->getMessage();

      // debug
      // implement by appropriate manner the 
      // following code.
      TheWorld::instance()->logger->log(KLogger::WARN, $message);
      TheWorld::instance()->debugStream->varDump($message);
      // end of debug
    }

    return true;
  }

  /*
  public function getViewPath() {
    $viewPath = $basePath . sprintf("/app/%s/views/%s/%s", $this->module, $this->controller, $this->action);

    $realPath = realpath($viewPath);
    if ($realPath === false) {
      throw new Exception("Dispatcher::getViewPath(): invalid path to include view: " . $viewPath);
    }

    return $realPath;
  }
  */

}

?>
