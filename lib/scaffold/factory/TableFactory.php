<?php

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

  public function make($type, $tableName) {
    $klassName = sprintf("%sTable", $type);
    $fileName = realpath(sprintf("%s/lib/scaffold/factory/%s.php", TheWorld::instance()->getBaseDir(), $klassName));
    // debug
    // add existence of class file with real path.
    // end of debug

    $object = new $klassName($tableName);

    return $object;
  }

}

?>