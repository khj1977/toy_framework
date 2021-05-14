<?php

require_once("lib/BaseTwoColScaffoldController.php");
require_once("lib/TheWorld.php");
require_once("lib/stream/HTMLDebugStream.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class ScaffoldTwoColTestController extends BaseTwoColScaffoldController {

  public function __construct() {
    parent::__construct();

    // rest of work is how to specify view.
    $this->isScaffold = true;
    // $this->modelName = "TestTableModel";
    // $this->modelName = "AddressModel";
    $this->modelName = "EmployeeListModel";

    $elements = KArray::new();
    $element = KHash::new()->set("href", "/index.php?m=sample_app&c=ScaffoldMasterData&a=klist")->set("desc", "Master Data")->set("is_active", false);
    $elements->push($element);

    $element = KHash::new()->set("href", "index.php?m=sample_app&c=ScaffoldTwoColTest&a=klist")->set("desc", "Employee")->set("is_active", true);
    $elements->push($element);
    
    $this->setNavViewElements($elements)->setNavView();
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