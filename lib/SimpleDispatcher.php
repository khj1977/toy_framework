<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/WebRouter.php");
require_once("lib/TheWorld.php");
require_once("lib/KException.php");
require_once("lib/WebArguments.php");
require_once("lib/stream/HTMLDebugStream.php");
require_once("lib/util/SimpleSession.php");

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

    // session_start();
    $session = new SimpleSession();
    $session->start();

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

    $controllerPath = Util::realpath($controllerPath);
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
      // debug
      // refacor the following to accept controller output handler which is object and instance of ControllerOutputHandler.
      // Expected kind of output handlers are html or view handler, JSON output handler, and XML output handler.
      // To specify output handler would be done by GET URL. It is litte bit risky to think about secutiry. However, since this framework is used for intra net, it would be acceptable.
      // The better implementation considering about secutiry would be implemented later on. Since this code is just a prototype, it is OK.
      
      if ($router->hasOutputHandler()) {
        $outputHandlerPath = $basePath . 
        sprintf(
          "/apps/%s/output_handlers/%sOutputHandler.php",
          $this->module,
          Util::upperCamelToUnderScore($this->outputHandler)
        );

        $outputHandlerPath = Util::realpath($outputHandlerPath);
        if ($outputHandlerPath === false) {
          throw new KException("Dispatcher::dispatch(): invalid path: with module and outputHandler: module: " . $this->module . " output handler: " . $this->outputHandler);
        }
        require_once($outputHandlerPath);
        $outputHandlerClassName = Util::underscoreToUpperCamel($this->outputHandler) . "OutputHandler";

        $outputHandler = new $outputHandlerClassName();
        $controller->setOutputHandler($outputHandler);
      }

      $subView = $controller->$actionName();
      // end of debug

      $controller->postAction();

      if (!$controller->isScaffold()) {
        // array("view_path" => foo, 
        // "view_class_name" => bar);
        $viewVals = $router->getView($controller);
      }
      else {
        $viewVals = $router->getView($controller);
      }
      
      require_once($viewVals["view_path"]);
    }
    catch(Exception $e) {
      $message = "Dispatcher: " . $e->getMessage();

      TheWorld::instance()->logger->log(KLogger::ERROR, $message);
      TheWorld::instance()->logger->log(KLogger::ERROR, $e->getTraceAsString());

      require_once("lib/view_template/ErrorViewTemplate.php");
      exit;
    }

    return true;
  }

  /*
  public function getViewPath() {
    $viewPath = $basePath . sprintf("/app/%s/views/%s/%s", $this->module, $this->controller, $this->action);

    $realPath = Util::realpath($viewPath);
    if ($realPath === false) {
      throw new Exception("Dispatcher::getViewPath(): invalid path to include view: " . $viewPath);
    }

    return $realPath;
  }
  */

}

?>
