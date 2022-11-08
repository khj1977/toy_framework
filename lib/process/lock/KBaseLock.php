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

    public function initialize()
    {
        parent::initialize();

        $this->state = new KBaseObjectState();
    }

    public function lock($process) {
        return $this->getLock($process);
    }

    // return state?
    public function getLock($process) {
        // debug
        // implement this method.
        // end of debug
    }

    public function freeLock() {
        // debug
        // implement this method.
        // end of debug
    }

    public function isLocked() {
        return $this->state->getState();
    }

    public function isFree() {
        // debug
        // implement this method.
        // end of debug

        return !$this->state->getState();
    }

}

?>