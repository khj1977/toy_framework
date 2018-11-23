<?php

require_once("lib/BaseDelegatable.php");

class MyPdoStatement extends BaseDelegatable {

  protected $statement;

  public function __construct($statement) {
    $this->statement = $statement;
    $this->setImpl($statement);

    return $this;
  }

}

?>