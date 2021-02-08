<?php

require_once("lib/data_struct/KSequential.php");
require_once("lib/data_struct/KArray.php");

// why yet another range? because if the result of loop is large enough, it is
// difficult to make array as a result of each(), etc. It means if the result of 
// loop is 100 or so, it could be KSeqRange. If it were 1,000,000 or so, it could be
// KRange.
class KSeqRange extends KSequential {

  protected $initialVal;
  protected $maxVal;
  protected $incrementalVal;

  protected $internalArray;

  protected $compareFunc;

  protected function initialize() {
    $this->internalArray = new KArray();

    return $this;
  }

  public function set($initialVal, $maxVal, $incrementalVal, $compareFunc = null) {
    $this->initialVal = $initialVal;
    $this->maxVal = $maxVal;
    $this->incrementalVal = $incrementalVal;

    if ($compareFunc === null) {
      $this->compareFunc = function($a, $b) {
        if ($a < $b) {
          return true;
        }
        
        return false;
      };
    }
    else {
      $this->compareFunc = $compareFunc;
    }

    return $this;
  }

  public function push($element) {
    $this->internalArray->push($element);

    return $this;
  }

  public function generator() {
    if ($this->internalArray->len() != 0) {
      foreach($this->internalArray->generator() as $element) {
        yield $element;
      }

      return $this;
    }

    // for($i = $this->initialVal; $i < $this->maxVal; $i = $i + $this->incrementalVal) {
    $cf = $this->compareFunc;
    for($i = $this->initialVal; $cf($i, $this->maxVal); $i = $i + $this->incrementalVal) {
      yield $i;
    }

    return $this;
  }

}

?>