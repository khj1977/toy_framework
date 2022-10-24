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
    // better choice.
    public function talk($f) {
        return $f($this->internalObject);
    }
}

?>