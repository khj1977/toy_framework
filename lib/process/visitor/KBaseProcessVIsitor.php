<?php

require_once("lib/BaseClass.php");

class KBaseProcessVisitor extends BaseClass {

    protected $currentProcess;
    protected $f;

    protected function initialize() {
        $this->currentProcess = null;
        $this->f = null;

        return $this;
    }

    public function exec($process, $arg) {

    }

    public function isAccept($edge) {

    }

    public function getCurrentProcess() {
        return $this->currentProcess;
    }

    public function setCurrentProcess($process) {
        $this->currentProcess = $process;

        return $this;
    }

    public function setExecBodyFunc($f) {
        $this->f = $f;

        return $this;
    }

}

?>