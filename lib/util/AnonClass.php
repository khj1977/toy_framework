<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class AnonClass extends BaseClass {

  public function __construct() {
    parent::__construct();
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  static public function makeObjectByHash($aHash) {
    $object = new AnonClass();
    foreach($aHash as $key => $val) {
      // The folloing property access is implemented by BaseClass.
      $object->$key = $val;
    }

    /*
    TheWorld::instance()->debugStream->varDump("anon");
    TheWorld::instance()->debugStream->varDump($object);
    */

    return $object;
  }

}

?>