<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KQueue.php");

// Kind of facade.
// Linear deliverly line.
class KBaseDeliveryLine extends KBaseInformation {

    protected $monitor;
    protected $q;

    public function initialize() {
        $this->q = new KQueue();
    }

    public function exec() {

    }

    // debug
    // parallel or serial? using strategy pattern or other class?
    // end of debug
    public function addPerson($person) {

    }

    public function pushItem($item) {

    }

    public function addFactor($deliverlyProcess, $dependencyProcess) {

    }

    public function relateProcess($process, $relatedProcess) {

    }

    public function setMonitor($f) {

    }

}

?>