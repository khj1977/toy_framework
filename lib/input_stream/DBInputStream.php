<?php

require_once("lib/input_stream/ABSInputStream.php");
require_once("lib/TheWorld.php");
require_once("lib/DB/MyPdo.php");

class DBInputStream extends ABSInputStream {

  protected $statement;
  protected $row;

  public function __construct() {
    parent::__construct();

    $this->statement = null;
    $this->row = null;

    return $this;
  }

  public function query($sql) {
    $this->statement = $slave->query($sql);

    return $this;
  }

  public function next() {
    $this->row = $this->statement->fetch();
    if (!$this->row) {
      return false;
    }

    return $this;
  }

  public function getItem() {
    return $this->row;
  }

}


?>