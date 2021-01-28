<?php

require_once("lib/BaseTwoColScaffoldController.php");
require_once("lib/TheWorld.php");
require_once("lib/stream/HTMLDebugStream.php");

class ScaffoldTwoColTestController extends BaseTwoColScaffoldController {

  public function __construct() {
    parent::__construct();

    // rest of work is how to specify view.
    $this->isScaffold = true;
    $this->modelName = "TestTableModel";
  }

  public function preAction() {
    $this->debugStream->setFlag(false);

    // debug
    // for test
    TheWorld::instance()->htmlDebugStream->varDump(HTMLDebugStream::KIND_ORDINARY, array(1, 2, 3));
    // end of debug
  }

}

?>