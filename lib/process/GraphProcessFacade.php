<?php

require_once("lib/process/BaseFacade.php");
require_once("lib/graph/GraphNode.php");

class GraphProcessFacade extends BaseFacade {
  protected $rootNode;

  public function __construct() {
    parent::__construct();
    
    $this->rootNode = null;

    return $this;
  }
}

?>