<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("BaseClass.php");
require_once("lib/TheWorld.php");

abstract class BaseProcess extends BaseClass {
  protected $supervisor;
  protected $lock;

  final public function exec() {
    if (!$this->supervisor->canExec()) {
      return $this;
    }

    if ($this->lock->isLocked($this)) {
      return $this;
    }

    try {
      $this->preExec();
      $this->xexec();
      $this->postExec();

      $this->supervisor->askPostExec();
    }
    catch(KException $ex) {
      $theWorld = TheWorld::instance();
      $loggerMessage = "BaseProcess::exec()". $ex->getMessage();
      $theWorld->logger->log($theWorld->const->logger_warn, $loggerMessage);

      // Finally, exception is handled by top layer of this framework.
      throw new KException($loggerMessage);
    }

    return $this;
  }

  public function setSuperVisor($superVisor) {
    $this->supervisor = $superVisor;
    $this->supervisor->setStudent($this);

    return $this;
  }

  public function setLock($lock) {
    $this->lock = $lock;

    return $this;
  }

  abstract protected function preExec();
  abstract protected function xexec();
  abstract protected function postExec();

}

?>