<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KString.php");

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

  public function popUntil($key) {
    $len = count($this->internalArray);
    for ($i = $len - 1; $i >= 0; --$i) {
      $tmpKey = $this->internalArray[$i];
      if (KString::isEqual($tmpKey, $key)) {
        break;
      }
      $this->pop();
    }

    return $this;
  }

  // even it is O(n), if len of array is small enough, it is ok.
  public function check($val) {
    foreach($this->internalArray as $element) {
      if (KString::isEqual($val, $element)) {
        return true;
      }
    }

    return false;
  }

  public function setFunctionWhenPush($anonFunction) {
    $this->anonFunction = $anonFunction;

    return $this;
  }

  public function generator() {
    foreach($this->internalArray as $element) {
      yield $element;
    }

    return true;
  }
}

?>