<?php

require_once("lib/BaseClass.php");

class KProcessVisitor extends BaseClass {

    protected $currentProcess;

    protected function initialize() {
        $this->currentProcess = null;

        return $this;
    }

    public function exec($process, $arg) {

    }

    public function getCurrentProcess() {
        return $this->currentProcess;
    }

    public function setCurrentProcess($process) {
        $this->currentProcess = $process;

        return $this;
    }

}

?>