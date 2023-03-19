<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("BaseClass.php");
require_once("lib/TheWorld.php");
require_once("lib/process/lock/KBaseLock.php");

abstract class BaseProcess extends BaseClass {
  protected $supervisor;
  protected $lock;

  protected function initialize()
  {
    parent::initialize();

    $this->supervisor = null;
    $this->lock = new KBaseLock();

    return $this;
  }

  final public function exec() {
    if (!$this->supervisor->canExec()) {
      return $this;
    }

    if ($this->lock->isLocked($this)) {
      return $this;
    }

    try {
      $this->supervisor->askPreExec();

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

  public function lock() {
    $lock = new KBaseLock();
    $this->lock($this, null);

    return $this;
  }

  abstract protected function preExec();
  abstract protected function xexec();
  abstract protected function postExec();

}

?>