<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KArray.php");

abstract class BaseGraphNode extends BaseClass {

  protected $edges;
  protected $content;

  public function __construct() {
    parent::__construct();

    $this->edges = new KArray();

    return $this;
  }

  public function addEdge($anEdge) {
    $this->edges->push($anEdge);

    $anEdge->setPrevNode($this);
    $anEdge->setNextNode(null);

    return $this;
  }

  public function setConetnt($anContent) {
    $this->content = $anContent;

    return $this;
  }

  public function getContent() {
    return $this->content;
  }

  public function mapToEdges($f) {
    $this->edges->each(function ($element) use($f) {
      $f($element);
    });
  }

}

?>