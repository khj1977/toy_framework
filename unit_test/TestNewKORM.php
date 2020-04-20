<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/KORM.php");
require_once("apps/sample_app/models/TestTableModel.php");

class TestNewKORM extends BaseUnitTest {


  public function test_initialized() {
    $initialized = KORM::getStateInitialized();

    $this->debugStream->varDump($initialized);

    return true;
  }

  public function test_fetch() {
    $modelName = "TestTableModel";
    $orms = $modelName::fetch(null, null, null);
    // KORM::setTableName("test_table");
    // $orms = KORM::fetch();
    // var_dump($orms);
    foreach($orms as $orm) {
      // $this->debugStream->varDump($orm);
      $this->debugStream->varDump($orm->foo);
    }

    return true;
  }

  public function test_fetch_one() {
    $modelName = "TestTableModel";
    $orm = $modelName::fetchOne();
    $this->debugStream->varDump($orm->foo);

    return true;
  }

}

?>