<?php

require_once("lib/BaseClass.php");

class KRange extends BaseClass {

  protected $initialVal;
  protected $maxVal;
  protected $incrementVal;

  public function set($initialVal, $maxVal, $incrementVal) {
    $this->initialVal = $initialVal;
    $this->maxVal = $maxVal;
    $this->incrementalVal = $incrementVal;

    return $this;
  }

  // debug
  // < or > should be determined by strategy pattern.
  // end of debug
  public function generator() {
    for($i = $this->initialVal; $i < $this->maxVal; $i = $i + $this->incrementalVal) {
      yield $i;
    }

    return $this;
  }

  public function each($f) {
    foreach($this->generator() as $i) {
      $f($i);
    }

    return $this;
  }

  public function do($f) {
    return $this->each($f);
  }

}

?>