<?php

require_once("lib/BaseClass.php");

class KDoubleLinkedListNode extends BaseClass {

  protected $content;
  protected $prev;
  protected $next;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function initialize() {
    parent::initialize();

    $this->content = null;
    $this->prev = null;
    $this->next = null;

    return $this;
  }

  public function isFirst() {
    if ($this->prev == null) {
      return true;
    }

    return false;
  }

  public function isLast() {
    if ($this->next == null) {
      return true;
    }

    return false;
  }

  public function setPrev($prev) {
    // No check of current prev.
    $this->prev = $prev;

    return $this;
  }

  public function setNext($next) {
    // No check of current next.
    $this->next = $next;

    return $this;
  }

  public function getNext() {
    return $this->next;
  }

  public function getPrev() {
    return $this->prev;
  }

  public function setContent($content) {
    $this->content = $content;

    return $this;
  }

  public function getContent() {
    return $this->content;
  }

  

}

?>