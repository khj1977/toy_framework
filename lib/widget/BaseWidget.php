<?php

require_once("lib/view/BaseView.php");
require_once("lib/view/BreadCrumbView.php");

abstract class BaseWidget extends BaseView {

  protected $modelName;
  protected $internalView;
  protected $parentView;

  protected $preRunFunc;
  protected $postRunFunc;

  protected function initialize() {
    $this->modelName = null;
    $this->internalView = null;
    $this->parentView = null;

    // args of the following anon func is instance of this class or widget.
    $this->preRunFunc = function($that){return $that;};
    $this->postRunFunc = function($that){return $that;};

    return $this;
  }

  public function setModelName($modelName) {
    $this->modelName = $modelName;

    return $this;
  }

  public function setParentView($parentView) {
    $this->parentView = $parentView;

    return $this;
  }

  public function setPreRunFunc($f) {
    $this->preRunFunc = $f;

    return $this;
  }

  public function setPostRunFunc($f) {
    $this->postRunFunc = $f;

    return $this;
  }

  public function run() {
    $this->preRun();
    $result = $this->xrun();
    $this->postRun();

    return $this;
  }

  abstract public function xrun();

  public function setView($view) {
    $this->internalView = $view;

    return $this;
  }

  public function render() {
    return $this->internalView->render();
  }

  protected function preRun() {
    if ($this->preRunFunc == null) {
      return $this;
    }

    $f = $this->preRunFunc;
    $f($this);

    return $this;
  }

  protected function postRun() {
    if ($this->postRunFunc == null) {
      return $this;
    }
    
    $f = $this->postRunFunc;
    $f($this);

    return $this;
  }

}

?>