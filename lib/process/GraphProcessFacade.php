<?php

require_once("lib/graph/BaseGraphNode.php");
require_once("lib/process/graph/KFacadeGraphNode.php");

require_once("lib/data_struct/KHash.php");

// The basic idea of GraphProcessFacade is come from the Apache nifi.
class GraphProcessFacade extends KFacadeGraphNode {
  protected $rootNode;

  public function __construct() {
    parent::__construct();
    
    $this->rootNode = new BaseGraphNode();

    return $this;
  }

  // debug
  // This methodology of iteration could be changed.
  /*
  public function exec() {
    $iterator = $this->rootNode->getIterator();
    while($node = $iterator->getNextNode()) {
      $process = $node->getContent();
      $process->exec();
    }

    return $this;
  }
  */

  public function exec($f) {
    $nodeMemory = new KHash();
    $this->node->mapToEdges(function($edge) use($f, $nodeMemory) {
      $key = $edge->getName();
      if ($nodeMemory->check*($key)) {
        return;
      }

      $nodeMemory->set($key, true);

      $node = $edge->getNextNode();

      $f($node);
    });
  }
  // end of debug

  // visitor determines what to do and traversal strategy.
  // As pointed by someone, it is interesting to split visitor and traversal
  // strategy. However, I think it is better to combine invoketor of process
  // and traversal stragey considering the nature of graph and strategy will
  // be determined by content of node.
  // There is possibility this determination could be changed.
  public function traverseByVisitor($visitor) {

  }

}

?>