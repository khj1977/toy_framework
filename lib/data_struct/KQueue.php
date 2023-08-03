<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KDoubleLinkedList.php");
require_once("lib/data_struct/KDoubleLinkedListNode.php");
require_once("lib/data_struct/KQueue.php");
require_once("lib/data_struct/KSequential.php");

// FIFO queue.
class KQueue extends KSequential {
  protected $internalList;


  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function initialize() {
    $this->internalList = new KDoubleLinkedList();

    return $this;
  }

  // Length is fixed
  public function setLength($len) {
    $currentLen = $this->internalList->getLength();
    if ($len < $currentLen) {
      return $this;
    }

    for($i = $currentLen; $i < $len; ++$i) {
      $this->internalList->addNode(new KDoubleLinkedListNode());
    }

    return $this;
  }

  // push an element and pop first element if necessary.
  public function push($element) {
    // $firstNode = $this->internalList->removeFirstNode();
    $firstNode = $this->pop();
    $this->internalList->add($element);

    // debug
    // Should it be fixed length queue?
    return $firstNode->getContent();
    // end of debug
  }

  public function pushOnly($element) {
    $this->internalList->add($element);

    return $this;
  }

  public function pop() {
    $firstNode = $this->internalList->removeFirstNode();

    return $firstNode;
  }

  public function generator() {
    foreach($this->internalList as $content) {
      yield $content; 
    }

    return true;
  }

}

?>