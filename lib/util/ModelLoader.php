<?php

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");
require_once("lib/KException.php");
require_once("lib/util/Util.php");

class ModelLoader extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  // use the current module to determine model path.
  public function load($modelName) {
    $moduleName = TheWorld::instance()->router->getModule();
    $modelFilePath = TheWorld::instance()->getBaseDir() . "/apps/" . $moduleName . "/models/" . $modelName . ".php";
    $realModelFilePath = Util::realPath($modelFilePath);
    if ($realModelFilePath === false) {
      throw new KException("BaseScaffoldController::upadte(): file " . $modelFilePath . " is not found.");
        }
    require_once($realModelFilePath);

    return $this;
  }

}

?>