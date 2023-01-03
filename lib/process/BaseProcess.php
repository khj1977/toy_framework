<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("BaseClass.php");

abstract class BaseProcess extends BaseClass {
  protected $supervisor;

  public function exec() {
    if (!$this->supervisor->canExec()) {
      return $this;
    }

    $this->preExec();
    $this->xexec();
    $this->postExec();

    return $this;
  }

  public function setSuperVisor($superVisor) {
    $this->supervisor = $superVisor;
    $this->supervisor->setStudent($this);

    return $this;
  }

}

?>