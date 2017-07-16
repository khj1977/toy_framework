<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");

class BaseConfigImpl extends BaseClass {

  protected $baseDir;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // example
    // debug
    // implement the following method for Env.
    $this->baseDir = TheWorld::instance()->env->base_dir();
    // end of debug

    return $this;
  }

}

?>