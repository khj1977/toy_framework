<?php

require_once("lib/view/BaseView.php");

// render() is remain to abstract.
abstract class BaseScaffoldView extends BaseView {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

}

?>