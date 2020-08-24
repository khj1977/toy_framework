<?php

require_once("lib/process/BaseFacade.php");
require_once("lib/graph/GraphNode.php");

// The basic idea of GraphProcessFacade is come from the Apache nifi.
class GraphProcessFacade extends BaseFacade {
  protected $rootNode;

  public function __construct() {
    parent::__construct();
    
    $this->rootNode = null;

    return $this;
  }

  public function exec() {
    $iterator = $this->rootNode->getIterator();
    while($node = $iterator->getNextNode()) {
      $process = $node->getContent();
      $process->exec();
    }

    return $this;
  }

}

?>