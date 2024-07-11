<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegatable.php");
require_once("lib/TheWorld.php");
require_once("lib/DB/MyPdoStatement.php");

class MyPdo extends BaseDelegatable {

  protected $pdo;

  // Generally, this method object is made by TheWorld and TheWorld know db name.
  public function __construct($dbProps) {
    parent::__construct();

    $this->pdo = new PDO(
      "mysql:dbname=" . $dbProps["name"] . 
      ";host=" . $dbProps["host"] . ";port=" . $dbProps["port"], 
      $dbProps["user"], 
      $dbProps["pass"]
    );

    $this->setImpl($this->pdo);

    return $this;
  }

  // debug
  // Refactered the following tO handle query error.
  // end of debug
  public function prepare($sql, $isLog = true) {
    if ($isLog === true) {
      TheWorld::instance()->logger->log(KLogger::INFO, "prepare:\t" . $sql);
    }

    $rawStatement = $this->pdo->prepare($sql);
    $statement = new MyPdoStatement($rawStatement, $sql);
    
    return $statement;
  }
  
  // debug
  // Refactered the following tO handle query error.
  // end of debug
  public function query($sql, $isLog = true) {
    if ($isLog === true) {
      TheWorld::instance()->logger->log(KLogger::INFO, "query:\t" . $sql);
    }

    // $result = $this->pdo->query($sql);
    $statement = $this->prepare($sql);
    $statement->execute();

    // var_dump($statement);

    return $statement;
  }

  public function bulkQuery($sql) {
    // no logging of query because it is too much
    $statement = new MyPdoStatement($this->pdo->query($sql));

    return $statement;
  }

}

?>