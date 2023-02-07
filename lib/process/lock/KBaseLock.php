<?php

require_once("lib/BaseClass.php");
require_once("lib/process/state/KBaseObjectState.php");

// Lock flow between proccess to process.
// State of exec chain of process flows.
// If process is required to be synced with multiple processes,
// a process should wait another process.
// In that time, lock is used to lock state of process.
class KBaseLock extends BaseClass {

    // KBaseProcessState
    protected $state;
    protected $process;
    protected $superVisor;

    public function initialize()
    {
        parent::initialize();

        $this->state = new KBaseObjectState();

        return $this;
    }

    public function lock($process) {
        $this->process = $process;
        $this->setSuperVisor($this->process);
        $this->setLock($this->process);
        return $this->getLock($this->process);
    }

    public function setLock() {
        $this->state->lock();

        return $this;
    }

    // return state?
    public function getLock() {
        return $this->state->getLock();
    }

    public function freeLock() {
        $this->state->freeLock();

        return $this;
    }

    public function isLocked() {
        return $this->state->getState();
    }

    public function isFree() {

        return !$this->state->getState();
    }

    public function setSuperVisor($superProcess) {
        $this->superVisor = $superProcess;

        return $this;
    }

}

?>