<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KDoubleLinkedList.php");
require_once("lib/data_struct/KDoubleLinkedListNode.php");

// FIFO queue.
class KQueue extends BaseClass {
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
    $firstNode = $this->internalList->removeFirstNode();
    $this->internalList->add($element);

    // debug
    // Should it be fixed length queue?
    return $firstNode->getContent();
    // end of debug
  }

}

?>