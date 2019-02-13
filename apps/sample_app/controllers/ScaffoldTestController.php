<?php

require_once("lib/BaseScaffoldController.php");

class ScaffoldTestController extends BaseScaffoldController {

  public function __construct() {
    parent::__construct();

    // rest of work is how to specify view.
    $this->isScaffold = true;
    $this->modelName = "TestTableModel";
  }

  public function preAction() {
    $this->debugStream->setFlag(false);
  }

}

?>