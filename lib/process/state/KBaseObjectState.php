<?php

require_once("lib/BaseClass.php");

// This class expresses state of something such as purchased book.
// state could be ordered, searching in warehouse or even shipped.
class KBaseObjectState extends BaseClass {
    protected $internalState;

    public function initialize() {
        parent::initialize();

        $this->internalState = null;
    }

    public function getState() {
        return  $this->delegate;
    }

    public function setInternalStateAsDelegate($state) {
        // $this->internalState = $state;
        $this->setDelegate($state);

        return $this;
    }
}

?>