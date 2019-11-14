<?php

require_once("lib/BaseClass.php");

class GraphNode extends BaseClass{

  protected $edges;

  public function __construct() {
    parent::__construct();

    $this->edges = array();

    return $this;
  }
}

?>