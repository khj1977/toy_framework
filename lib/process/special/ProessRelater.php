<?php

require_once("lib/BaseClass.php");

class ProcessRelater extends BaseClass {

    protected $originalProcess;
    protected $destinationProcess;

    public function setOriginalProcess($orgP) {
        $this->originalProcess = $orgP;

        return $this;
    }

    public function setDestinationProcess($destP) {
        $this->destinationProcess = $destP;

        return $this;
    }

}

?>