<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KQueue.php");

class KBaseProcessQueue extends BaseClass {

    protected $internalQueue;
    protected $monitor;

    public function initilize() {
        $this->internalQueue = new KQueue();
        $this->monitor = null;

        return $this;
    }

    public function push($process) {
        if ($this->monitor != null) {
            $f = $this->monitor;

            yield $f($process);
        }
        $this->internalQueue->pushOnly($process);

        return $this;
    }

    public function pop($hookF = null) {
        $process = $this->internalQueue->pop();

        if ($hookF != null) {
            $hookF($process);
        }

        return $process;
    }

    public function apply($f) {
        $this->internalQueue->each(function($element) use($f)  
            {
                $f($element);
            }
        );

        return $this;
    }

    public function runFunction($f) {
        return $this->apply($f);
    }

    public function map($f) {
        return $this->apply($f);
    }

    public function setMonitor($f) {
        $this->monitor = $f;

        return $this;
    }

}

?>