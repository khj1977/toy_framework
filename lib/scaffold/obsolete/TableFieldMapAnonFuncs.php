<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

// Obtain anon-funcs using getter of this class.
class TableFieldMapAnonFuncs extends BaseClass {

  protected $tableName;

  // protected $anonFuncs;

  public function __construct($tableName) {
    // debug
    // implement this method;
    throw new Exception("TableFieldMapAnonFuncs::__construct(): this method has not been implemented yet.");
    // end of debug

    $this->initialize($tableName);

    $this->setAccessibles("anon_funcs");

    return $this;
  }

  protected function initialize($tableName) {
    $this->tableName = $tableName;

    $this->initializeAnonFuncs();

    return $this;
  }

  protected function initializeAnonFuncs() {
    // read definition of anon func from config file or define anon func for each table
    // by sub class.

    // For simplest case, the definition of anon func inside this class may be as follows:
    // $this->func_foo = ...;
    // $this->func_bar = ...;
    // For first step, the most simple implementaion will be used, since this is not point of
    // this library.

    return $this;
  }



}

?>