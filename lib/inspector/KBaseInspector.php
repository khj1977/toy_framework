<?php

require_once("lib/BaseClass.php");

class KBaseInspector extends BaseClass {
    
    protected $internalObject;

    protected function initialize() {
        parent::initialize();

        $this->internalObject = null;

        return $this;
    }

    public function setObject($object) {
        $this->internalObject = $object;
    }

    // $f could be function object but it is supposed that anon function is
    // better choice. There would be some set of template functions passed to 
    // this method.
    public function talk($f) {
        $this->preTalk();
        $result = $f($this->internalObject);
        $this->postTalk();

        return $result;
    }

    protected function preTalk() {
        // debug
        // implement this method.
        // end of debug

        return $this;
    }

    protected function postTalk() {
        // debug
        // implement this method.
        // end of debug

        return $this;
    }

}

?>