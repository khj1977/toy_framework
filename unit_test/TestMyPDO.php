<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/TheWorld.php");

class TestMyPDO extends BaseUnitTest {

  public function test_bulkQuery() {
    $sql = "INSERT INTO test_table (foo, bar, product_id) values('cinamon', 1, 2)";
    $err = TheWorld::instance()->master->bulkQuery($sql);

    $this->debugStream->varDump($err);

    return true;
  }

  public function test_query() {
    $sql = "SELECT * FROM test_table";
    $statement = TheWorld::instance()->slave->query($sql);

    // $this->debugStream->varDump($statement);
    while($row = $statement->fetch()) {
      $this->debugStream->varDump($row);
    }

    return true;
  }

}

?>