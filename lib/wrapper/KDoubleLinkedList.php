<?php

require_once("lib/BaseClass.php");
require_once("lib/wrapper/KDoubleLinkedListNode.php");

class KDoubleLinkedList extends BaseClass { 
  protected $firstNode;
  protected $lastNode;
  protected $len;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function initialize() {
    parent::initialize();

    $this->firstNode = null;
    $this->lastNode = null;
    $this->len = 0;

    return $this;
  }

  public function getFirstNode() {
    return $this->firstNode;
  }

  public function getLastNode() {
    return $this->lastNode;
  }

  public function addNode($node) {
    if ($this->firstNode == null) {
      $this->firstNode = $node;
      $this->lastNode = $node;
      $node->setPrev(null);
      $node->setNext(null);

      $this->len = 1;
    }
    else {
      $prevLastNode = $this->lastNode;
      $this->lastNode->setNextNode($node);
      $this->lastNode = $node;

      $node->setNext(null);
      $node->setPrev($prevLastNode);

      $this->len = $this->len + 1;
    }

    return $this;
  }

  public function getLength() {
    return $this->len;
  }

  public function removeFirstNode() {
    $secondNode = $this->firstNode->getNext();
    $this->firstNode = $secondNode;

    return $this;
  }

  public function generator() {
    $node = $this->firstNode;
    while(true) {
      if ($node == null) {
        break;
      }

      yield $node->getContent();

      $node = $node->getNext();
    }

    return true;
  }

}

?>