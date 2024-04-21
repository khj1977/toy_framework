<?php

require_once("lib/view/KBaseNavView.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class VNavView extends KBaseNavView {

  protected function initialize() {
    parent::initialize();
    // $this->elements = KArray::new();
    
    $this->styleOfNav = '<ul class="nav nav-tabs">';

    return $this;
  }

}

?>