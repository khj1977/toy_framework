<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

// Although DI is used in this class, Factory class made by another file is not used to
// omit dependency of base of framework.

// require_once("lib/BaseClass.php");
require_once("lib/BaseDelegatable.php");
require_once("lib/UException.php");

class BaseConfig extends BaseDelegatable {

  protected $stage;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  // Basically, determine stage by env val.
  protected function determineStage() {
    // debug
    throw new UException("BaseConfig::determineStage(): this method has not been implemented yet.");
    // end of debug

    $this->loadImpl();

    return $this;
  }

  public function setStage($stage) {
    $this->stage = $stage;
  }

  protected function loadImpl() {
    // check stage is valid. (by existence of impl file)
    // load impl file with respect to stage.
    // make instance with that file.
    // set impl with a method.

    // debug
    // include checking existense of file by some function or method.
    // end of debug

    $configFilePath = $this->getConfigFilePath();
    require_once($this->configFilePath);

    $this->setImpl($this->getConfigFileName());

    return $this;
  }

  protected function getConfigFilePath() {
    $fileName = $this->getConfigFileName($this->stage);
    $dirPath = $this->getConfigDirPath();

    $result = $dirPath . "/" . $fileName;

    return $result;
  }

  protected function getConfigFileName() {
    $configFileName = sprintf("%sConfigImpl.php", $this->stage);

    return $configFileName;
  }

  protected function getConfigDirPath() {
    return "lib/config/impl/";
  }

}

?>