<?php

require_once("lib/BaseClass.php");

class KBaseInspector extends BaseClass {
    
    protected $internalObject;

    protected $defaultTalkFunction;
    protected $defaultPreTalkFunction;
    protected $defaultPostTalkFunction;

    protected function initialize() {
        parent::initialize();

        $this->internalObject = null;

        $this->defaultTalkFunction = function($obj) {return;};
        $this->defaultPreTalkFunction = function($obj) {return;};
        $this->defaultPostTalkFunction = function($obj) {return;};

        return $this;
    }

    public function setObject($object) {
        $this->internalObject = $object;
    }

    // $f could be function object but it is supposed that anon function is
    // better choice. There would be some set of template functions passed to 
    // this method.
    public function talk($f = null) {
        if ($f == null) {
            $f = $this->defaultTalkFunction;
        }
        
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