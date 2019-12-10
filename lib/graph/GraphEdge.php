<?php

require_once("lib/BaseClass.php");

class GraphEdge extends BaseClass {

  protected $prevNode;
  protected $nextNode;

  public function __construct() {
    parent::__construct();

    $this->prevNode = null;
    $this->nextNode = null;

    return $this;
  }

  public function getPrevNode() {
    return $this->prevNode;
  }

  public function getNextNode() {
    return $this->nextNode;
  }

  public function setPrevNode($anNode) {
    $this->prevNode = $anNode;

    return $this;
  }

  public function setNextNode($anNode) {
    $this->nextNode = $anNode;

    return $this;
  }

}

?>