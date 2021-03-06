<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");

class DebugStream {
  
  protected $flag;

  public function __construct($stage) {
    // $stage = TheWorld::instance()->stage;
    if ($stage == "Dev") {
      $this->flag = true;
    }
    else {
      $this->flag = false;
    }

    return $this;
  }

  public function setFlag($aFlag) {
    $this->flag = $aFlag;

    return $this;
  }

  public function enable() {
    $this->flag = true;

    return $this;
  }

  public function disable() {
    $this->flag = false;

    return $this;
  }

  public function varDump($anObject) {
    if ($this->flag === false) {
      return $this;
    }

    var_dump($anObject);

    return $this;
  }

  // Yet another name of varDump
  public function vd($anObject) {
    return $this->varDump($anObject);
  }

  public function println($aString) {
    if ($this->flag === false) {
      return $this;
    }

    $msg = $aString . "\n";
    print($msg);

    return $this;
  }

  public function pl($aString) {
    return $this->println($aString);
  }

}

?>