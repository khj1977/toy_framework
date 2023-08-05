<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KQueue.php");

// debug
// possibly this class could be child of KSeq.
// end of debug
class KBaseProcessQueue extends BaseClass {

    protected $internalQueue;

    public function initilize() {
        $this->internalQueue = new KQueue();

        return $this;
    }

    public function push($process) {
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
    }

}

?>