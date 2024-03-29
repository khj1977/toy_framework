<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KQueue.php");
require_once("lib/process/util/ProessRelater.php");

// Kind of facade.
// Linear deliverly line.
class KBaseDeliveryLine extends KBaseInformation {

    protected $monitorOfStart;
    protected $monitorOfEnd;

    protected $qOfItems;
    protected $qOfPersons;

    protected $pRelater;

    public function initialize() {
        $this->qOfItems = new KQueue();
        $this->qOfPersons = new KQueue();

        $this->pRelater = new KProcessRelater();

        return $this;
    }

    // process queue of items by persons.
    public function exec() {

    }

    // serial process queue.
    public function addPerson($person) {
        $this->qOfPersons->push($person);

        return $this;
    }

    public function pushItem($item) {
        $this->qOfItems->push($item);

        return $this;
    }

    public function addFactor($deliverlyProcess, $dependencyProcess) {

    }

    public function relateProcess($process, $relatedProcess) {
        $this->pRelater->setOriginalProess($process);
        $this->pRelater->setDestinationProcess($relatedProcess);

        return $this;
    }

    public function setMonitorOfStart($f) {
        $this->monitorOfStart = $f;

        return $this;
    }

    public function setMonitorOfEnd($f) {
        $this->monitorOfEnd = $f;

        return $this;
    }

}

?>