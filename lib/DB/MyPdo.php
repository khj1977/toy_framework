<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegatable.php");
require_once("lib/TheWorld.php");

class MyPdo extends BaseDelegatable {

  protected $pdo;

  // Generally, this method object is made by TheWorld and TheWorld know db name.
  public function __construct($dbProps) {
    $this->pdo = new PDO(
      "mysql:dbname=" . $dbProps["name"] . 
      ";host=" . $dbProps["host"], 
      $dbProps["user"], 
      $dbProps["pass"]
    );

    $this->setImpl($this->pdo);
    parent::__construct();

    return $this;
  }

  public function prepare($sql) {
    // debug
    // TheWorld::instance()->getLogger()->log("info", "prepare:¥t" . $sql);
    // end of debug

    $rawStatement = $this->pdo->prepare($sql);
    $statement = new MyPdoStatement($rawStatement, $sql);
    
    return $statement;
  }
  
  public function query($sql) {
    // debug
    // TheWorld::instance()->getLogger()->log("info", "query:¥t" . $sql);
    // end of debug

    $this->pdo->query($sql);
  }

  public function bulkQuery($sql) {
    // no logging of query because it is too much
    $this->pdo->query($sql);

    return $this;
  }

}

?>