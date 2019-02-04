<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class BaseController extends BaseClass {

  public function __contruct() {
    parent::__contruct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function preAction() {
    // Do nothing. Not abstract.
  }

  public function postAction() {
    // Do nothing. Not abstract.
  }

}

?>