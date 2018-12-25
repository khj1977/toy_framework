<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class FieldFactory extends BaseClass {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();
    
    // debug 
    throw new Exception("FieldFactory::make(): implement this method.");
    // end of debug
  }

  // $anField = $fieldFactory->make($tableName, $col);
  public function make($tableName, $anDBCol) {
    // debug 
    throw new Exception("FieldFactory::make(): implement this method.");
    // end of debug
  }

}

?>