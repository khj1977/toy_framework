<?php

require_once("lib/BaseClass.php");

class GraphIterator extends BaseClass{

  protected $currentNode;

  public function __construct() {
    parent::__construct();

    $this->currentNode = null;

    return $this;
  }
}

?>