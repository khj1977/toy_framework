<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/TheWorld.php");
require_once("lib/DB/MyPdo.php");

class TestPDO extends BaseUnitTest {
  
    public function __construct() {
      // print("TestRSS has been made.\n");
  
      return true;
    }

    public function test_Conn() {
      $config = TheWorld::instance()->config;
      $dbProps = $config->getDBProps();

      $pdo = new MyPdo($dbProps);
      $statement = $pdo->prepare("SELECT * FROM bar");
      $statement->execute(array());
      while($rows = $statement->fetch()) {
        printf("line break conn: ¥n");
        var_dump($rows);
      }      
    }

    public function test_theworld() {
      $slave = TheWorld::instance()->slave;
      $statement = $slave->prepare("SELECT * FROM bar");
      $statement->execute(array());
      // $statement->execute(array());
      while($rows = $statement->fetch()) {
        print("line break. the world: ¥n");
        var_dump($rows);
      }
    }

}

?>