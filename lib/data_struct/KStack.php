<?php

require_once("lib/BaseClass.php");

class KStack extends BaseClass {
  protected $internalArray;
  // debug
  // Should implement exec($element)
  // Which is child class of BaseAnonFunction
  // Note that BaseAnonFuntion itself is abstract.
  // end of debug
  protected $anonFunction;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function initialize() {
    parent::initialize();

    $this->internalArray = array();
    $this->anonFunction = null;

    return $this;
  }

  public function push($element) {
    if ($this->anonFunction != null) {
      $this->anonFunction->exec($element);
    }

    $this->internalArray[] = $element;

    return $this;
  }

  public function pop() {
    $element = array_pop($this->internalArray);

    return $element;
  }

  public function setFunctionWhenPush($anonFunction) {
    $this->anonFunction = $anonFunction;

    return $this;
  }
}

?>