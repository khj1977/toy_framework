<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/util/AnonClass.php");
require_once("lib/KORM.php");
require_once("lib/TheWorld.php");
require_once("lib/scaffold/KORMTable.php");
require_once("lib/Util.php");

class TestKORMTable extends BaseUnitTest {

  public function test_initialize() {
    $table = new KORMTable("test_table");
    $dbCols = $table->getDBCols(1, null);
    foreach($dbCols as $dbCol) {
      Util::println($dbCol->toString());
    }
  }

}

?>