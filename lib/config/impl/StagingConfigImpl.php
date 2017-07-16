<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/config/impl/BaseConfigImpl.php");

class StagingConfigImpl extends BaseConfigImpl {

  public function __construct() {
    parent::__construct();
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

}

?>