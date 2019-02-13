<?php

require_once("lib/BaseScaffoldController.php");

class SampleScaffoldController extends BaseScaffoldController {
  protected $isScaffold;
  protected $modelName;

  public function preAction() {
    $this->debugStream->setFlag(false);
  }

  public function __construct() {
    parent::__construct();

    return $this->initialize();
  }

  protected function initialize() {
    parent::initialize();

    $this->isScaffold = true;
    $this->modelName = "TestTableModel";

    return $this;
  }

}

?>