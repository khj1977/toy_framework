<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/util/AnonClass.php");
require_once("lib/BaseKORMModel.php");
require_once("lib/KORM.php");
require_once("lib/TheWorld.php");

class TestTableModel extends BaseKORMModel {
    public function __construct($tableName) {
      parent::__construct($tableName);

      return $this;
    }
}

class TestKORMBasedModel extends BaseUnitTest {

  public function test_select() {
    $baseORM = new TestTableModel("test_table");
    $baseORMs = $baseORM->fetch();
    $propNames = $baseORM->getPropNames();
    foreach($baseORMs as $baseORM) {
      foreach($propNames as $propName) {
        Util::println(sprintf("%s: %s", $propName, $baseORM->$propName));
      }
    }

    return true;
  }

}

?>