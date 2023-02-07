<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KHash.php");

// This class expresses state of something such as purchased book.
// state could be ordered, searching in warehouse or even shipped.
class KBaseObjectState extends BaseClass {
    protected $internalState;

    const LOCK_KEY = "LOCK";

    public function initialize() {
        parent::initialize();

        $this->internalState = new KHash();
        $this->internalState->set(KBaseObjectState::LOCK_KEY, false);

        return $this;
    }

    public function getState() {
        return  $this->delegate;
    }

    public function setInternalStateAsDelegate($state) {
        // $this->internalState = $state;
        $this->setDelegate($state);

        return $this;
    }

    public function lock() {
        $this->internalState->set(KBaseObjectState::LOCK_KEY, true);

        return $this;
    }

    public function getLock() {
        return $this->internalState->set(KBaseObjectState::LOCK_KEY, false);
    }


}

?>