<?php

require_once("lib/BaseClass.php");

class KPair extends BaseClass {

    protected $fst;
    protected $snd;

    protected function initialize() {
        $this->fst = null;
        $this->snd = null;

        return $this;
    }


    public function setFirst($aContent) {
        $this->fst = $aContent;

        return $this;
    }

    public function setSecond($aContent) {
        $this->snd = $aContent;

        return $this;
    }

    public function getFirst() {
        return $this->fst;
    }

    public function getSecond() {
        return $this->snd;
    }

}

?>
