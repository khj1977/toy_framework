<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class FieldFactory {

  public function __construct() {
    $this->initialize();

    return $this;
  }

  protected function initialize() {
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