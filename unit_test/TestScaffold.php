<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/TheWorld.php");
require_once("lib/stream/DebugStream.php");
require_once("lib/scaffold/MySQLTable.php");

class TestScaffold extends BaseUnitTest {

  protected function preRun() {
    $this->debugStream->setFlag(true);
  }

  protected function postRun() {
    // Do nothing for base class.
  }

  public function test_PDO() {
    // $mysqlTable = new MySQLTable();
    $slave = TheWorld::instance()->slave;
    $debugStream = TheWorld::instance()->debugStream;

    $statement = $slave->prepare("SELECT * FROM test_table");
    $statement->execute(array());
    // $debugStream->varDump($statement);
    while($row = $statement->fetch()) {
      // $debugStream->varDump($row["id"]);
    }

    return true;
  }

  public function test_MySQLTable() {
    $sqlTable = new MySQLTable("test_table");

    // TheWorld::instance()->debugStream->varDump($sqlTable);
  }

  public function test_MySQLTableColProps() {
    // $this->debugStream->setFlag(false);

    $sqlTable = new MySQLTable("test_table");
    $this->debugStream->varDump("test foo");

    $rows = $sqlTable->getDBCols(1);
    // var_dump($this->debugStream);

    $this->debugStream->varDump($sqlTable->getColProps());

    $this->debugStream->varDump("db cols");
    $this->debugStream->varDump($dbCols);
    foreach($rows as $row) {
      foreach($row as $col) {
        $this->debugStream->varDump("db cols 2");;
        $this->debugStream->varDump($col->toString());
        // print($col->toString() . ": ¥n");
      }
    }
  }


}

?>
