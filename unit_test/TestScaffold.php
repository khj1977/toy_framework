<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/TheWorld.php");
require_once("lib/stream/DebugStream.php");
require_once("lib/scaffold/MySQLTable.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/Util.php");
require_once("lib/util/Assert.php");
require_once("lib/util/AnonClass.php");

class TestScaffold extends BaseUnitTest {

  protected function preRun() {
    $this->debugStream->setFlag(false);
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
    $this->debugStream->setFlag(false);

    $sqlTable = new MySQLTable("test_table");
    $this->debugStream->varDump("test foo");

    $rows = $sqlTable->getDBCols();
    // var_dump($this->debugStream);

    // $this->debugStream->varDump($sqlTable->getColProps());

    $this->debugStream->varDump("db cols");
    $this->debugStream->varDump($dbCols);

    $anonObject = array();
    $anonObjects[] =     AnonClass::makeObjectByHash(
      array(
        "name" => "bar", 
        "val" => "2", 
        "type" => "int"
        )
    );

    foreach($rows as $row) {
      foreach($row as $col) {
        $assert = new Assert();

        $err = $assert->objectEqual($col, $anonObjects[0]);
        if ($err = false) {
          return false;
        }

        $assert->resetNumEqual();

      }
    }

    return true;
  }

  public function test_ColFactory() {
    $tableName = "test_table";
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("MySQL", $tableName);
    // $sqlTable = new MySQLTable($tableName);
    $rows = $sqlTable->getDBCols(1);

    $factory = new SimpleCol2HTMLFieldFactory();

    $i = 0;
    foreach($rows as $row) {
      // var_dump("line num: " . $i);
      foreach($row as $col) {
        $this->debugStream->varDump("pre-html");
        // $html = $factory->make($tableName, $col);
        $col->setHTMLFactory($factory);
        $html = $col->render();

        $this->debugStream->varDump("html");
        $this->debugStream->varDump($html);
      }
      ++$i;
    }
  }

}

?>
