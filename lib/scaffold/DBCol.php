<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class DBCol extends BaseClass {

  // model not view. view will be HTMLField or something like that.
  // $field will fetch val and other info from instance of this class.
  protected $name;
  protected $val;

  public function __construct() {
    parent::__construct();
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // debug
    // for debug purpose, off now.
    // no effect to just apply get/set
    /*
    $this->setAccessible("col_name")->setAccessible("col_type")->setAccessible("col_val")->
      setAccessible("is_null");
    */
    // end of debug

    $this->name = null;
    $this->val = null;

    return $this;    
  }

  public function setNameValPair($name, $val) {
    $this->name = $name;
    $this->val = $val;

    return $this;
  }

  public function getName() {
    return $name;
  }

  public function getVal() {
    return $val;
  }

  public function toString() {
    $str = $this->name . " " . $this->val;

    return $str;
  }

}

?>