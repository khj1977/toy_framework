<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegatable.php");
require_once("lib/TheWorld.php");

class MyPdo extends BaseDelegatable {

  protected $conn;

  // Generally, this method object is made by TheWorld and TheWorld know db name.
  public function __construct($dbProb) {
    parent::__contruct();
    $this->conn = new My_Pdo(new PDO("mysql:dbname=" . $dbProb["name"] . 
      ";host=" . $dbProp["host"], 
      $dbProp["user"], 
      $dbProp["pass"]));

    $this->setImpl($this->conn);
    return $this;
  }

  public function prepare($sql) {
    TheWorld::instance()->getLogger()->log("info", "prepare:¥t" . $sql);
  
    $rawStatement = $this->pdo->prepare($sql);
    $statement = new MyPdoStatement($rawStatement, $sql);
    
    return $statement;
  }
  
  public function query($sql) {
    TheWorld::instance()->getLogger()->log("info", "query:¥t" . $sql);
    
    $this->pdo->query($sql);
  }

}

?>