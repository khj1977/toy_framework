<?php

require_once("lib/BaseClass.php");

abstract class KBaseLockObserver extends BaseClass {

    protected $toObserve;

    public function setToObserve($lock) {
        $this->toObserve = $lock;

        return $this;
    }

    abstract public function onChanged($lock);

}

?>