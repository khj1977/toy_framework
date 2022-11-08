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

        return $this;
    }

    public function setTalkFunction($f) {
        $this->defaultTalkFunction = $f;

        return $this;
    }

    public function setPreTalkFunction($f) {
        $this->defaultPreTalkFunction = $f;

        return $this;
    }

    public function setPostTalkFunction($f) {
        $this->defaultPostTalkFunction = $f;

        return $this;
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

    protected function preTalk($f = null) {
        if ($f == null) {
            $f = $this->defaultPreTalkFunction;
        }
        
        $result = $f($this->internalObject);

        return $result;
    }

    protected function postTalk($f = null) {
        if ($f == null) {
            $f = $this->defaultPostTalkFunction;
        }
        
        $result = $f($this->internalObject);

        return $result;
    }

}

?>