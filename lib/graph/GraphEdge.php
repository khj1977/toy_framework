<?php

require_once("lib/BaseClass.php");

class GraphEdge extends BaseClass{

  protected $prevNode;
  protected $nextNode;

  public function __construct() {
    parent::__construct();

    $this->prevNode = null;
    $this->nextNode = null;

    return $this;
  }
}

?>