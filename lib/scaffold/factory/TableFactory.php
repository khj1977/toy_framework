<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class TableFactory extends BaseClass {

  public function __construct() {
    parent::__construct();

    // $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  // debug
  // new ModelName should be implemtend.
  // otherwise, just table name with KORM.
  // end of debug
  public function make($type, $modelName) {
    $klassName = sprintf("%sTable", $type);
    $fileName = realpath(sprintf("%s/lib/scaffold/%s.php", 
    TheWorld::instance()->getBaseDir(), $klassName));

    // debug
    // add existence of class file with real path.
    // end of debug

    require_once($fileName);

    $object = new $klassName($modelName);

    return $object;
  }

}

?>