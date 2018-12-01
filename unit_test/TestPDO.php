<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));

class TestRSS extends BaseUnitTest {
  
    public function __construct() {
      // print("TestRSS has been made.\n");
  
      return true;
    }

    public function testConn() {
      $pdo = new PDO("mysql:dbname=" . "foo" . ";host=" . "127.0.0.1", "", "");
      $statement = $pdo->prepare("SELECT * FROM bar");
      $statement->execute(array());
      while($rows = $statement->fetch()) {
        printf("line break¥n");
        var_dump($rows);
      }
    }
}

?>