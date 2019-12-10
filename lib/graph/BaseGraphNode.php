<?php

require_once("lib/BaseClass.php");

abstract class BaseGraphNode extends BaseClass{

  protected $edges;
  protected $content;

  public function __construct() {
    parent::__construct();

    $this->edges = array();

    return $this;
  }

  public function addEdge($anEdge, $nextNode) {
    $anEdge->setPrevNode($this);
    $anEdge->setNextNode($nextNode);

    $this->edges[] = $anEdge;

    return $this;
  }

  public function setConetnt($anContent) {
    $this->content = $anContent;

    return $this;
  }

  public function getContent() {
    return $this->content;
  }

  abstract public function getIterator();

}

?>