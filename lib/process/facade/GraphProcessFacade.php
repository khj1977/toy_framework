<?php

require_once("lib/graph/BaseGraphNode.php");
require_once("lib/process/graph/KFacadeGraphNode.php");
require_once("lib/process/facade/BaseFacade.php");

require_once("lib/data_struct/KHash.php");

// The basic idea of GraphProcessFacade is come from the Apache nifi.
class GraphProcessFacade extends BaseFacade {
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

  // debug
  // think carefully about algo of traverse.
  public function exec($f, $visitor = null) {
    $edgeMemory = new KHash();

    $traverseFunc = function($node, $edge) use($f, $edgeMemory, $visitor, &$traverseFunc) {
      if (!$visitor->isAccept($edge)) {
        return $this;
      }

      $key = $edge->getName();
      if ($edgeMemory->check($key)) {
        return $this;
      }

      $edgeMemory->set($key, true);

      $node = $edge->getNextNode();

      if ($visitor === null) {
        $f($node);
      }
      else {
        $visitor->exec($node);
      }

      return $traverseFunc($f, $node->getFirstEdge());
    };

    $this->node->mapToEdges($traverseFunc);

    return $this;
  }
  // end of debug

  // visitor determines what to do and traversal strategy.
  // As pointed by someone, it is interesting to split visitor and traversal
  // strategy. However, I think it is better to combine invoketor of process
  // and traversal stragey considering the nature of graph and strategy will
  // be determined by content of node.
  // There is possibility this determination could be changed.
  public function traverseByVisitor($visitor) {
    $this->exec(null, $visitor);

    return $this;
  }

}

?>