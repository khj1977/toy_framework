<?php

require_once("lib/BaseClass.php");

abstract class BaseGraphIterator extends BaseClass {

  protected $currentNode;

  public function __construct() {
    parent::__construct();

    $this->currentNode = null;

    return $this;
  }

  abstract public function getNextNode();
  
}

?>