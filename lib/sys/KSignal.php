<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KHash.php");

// Typically, this signal, which is impled by UNIX signal, is used for
// impl of KTimer.
class KSignal extends BaseClass {

    protected $signalHandler;

    public function initialize() {
        $this->signalHandler = new KHash();

        return $this;
    }

    public function addHandler($sigNo, $f) {
        $this->signalHandler->set($this->getSigNoHashKey($sigNo), $f);
        $that = $this;

        $callback = function($x, $y) use($that, $sigNo) {$that->fireSignal($sigNo);};

        pcntl_signal($sigNo, $callback);

        return $this;
    }

    public function fireSignal($sigNo) {
        $key = $this->getSigNoHashKey($sigNo);
        if ($this->signalHandler->check($key)) {
            return $this;
        }

        $f = $this->signalHandler->get($key);
        $f();

        return $this;
    }

    protected function getSigNoHashKey($sigNo) {
        return "KSignal::" .  $sigNo;
    }

}

?>