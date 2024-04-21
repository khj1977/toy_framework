<?php

require_once("lib/view/KBaseNavView.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class HNavView extends KBaseNavView {

  protected function initialize() {
    // $this->elements = KArray::new();

    parent::initialize();

    $this->styleOfNav = '<ul class="nav nav-tabs">';

    return $this;
  }

}

?>