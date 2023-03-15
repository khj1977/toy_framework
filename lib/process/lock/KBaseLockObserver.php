<?php

require_once("lib/BaseClass.php");

abstract class KBaseLockObserver extends BaseClass {

    protected $toObserve;

    public function setToObserve($lock) {
        $this->toObserve = $lock;

        return $this;
    }

    // For instance, notify to object of manager class such that target process
    // is unclocked, therefore it is possible to send email to somewhere/someone.
    abstract public function onChanged();

}

?>