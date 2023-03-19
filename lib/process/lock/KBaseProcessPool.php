<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KQueue.php");

// This class is used to make process pause and retain in some state.
// Typically, wait shipping from manufacture.
class KBaseProcessPool extends BaseClass {

    protected $q;

    protected function initialize()
    {
        $this->q = new KQueue();

        return $this;
    }

    public function push($process) {
        $process->lock();
        $this->q->push($process);

        return $this;
    }

    public function pop() {
        return $this->q->pop();
    }

}

?>