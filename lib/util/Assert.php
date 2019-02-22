<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

// Instead of using Util::assertEqueal()
// use $assert->equal().
class Assert extends BaseClass {

  protected $numEqual;

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  public function initialize() {
    parent::initialize();

    $this->numEqual = 0;

    return $this;
  }

  public function getNumEqual() {
    return $this->numEqual;
  }

  public function resetNumEqual() {
    $this->numEqual = 0;

    return $this;
  }

  public function equal($val1, $val2) {
    if ($val1 === $val2) {
      $this->numEqual = $this->numEqual + 1;

      return true;
    }

    return false;
  }

  public function stringEqual($str1, $str2) {
    $err = strcmp($str1, $str2);
    if ($err === 0) {
      return true;
    }

    return false;
  }

  public function objectEqual($object1, $object2) {
    $props1 = $object1->getPropsAsHash();
    $props2 = $object2->getPropsAsHash();

    // debug
    $this->ds->vd("object equal");
    $this->ds->vd($props1);
    $this->ds->vd($props2);
    // end of debug

    foreach($props1 as $key => $val) {
      if (!array_key_exists($key, $props2)) {
        return false;
      }

      // debug
      // str_cmp or ==?
      if ($props2[$key] !== $props1[$key]) {
        return false;
      }
      // end of debug
    }

    $this->numEqual = $this->numEqual + 1;

    return true;
  }

}

?>