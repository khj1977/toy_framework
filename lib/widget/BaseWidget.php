<?php

require_once("lib/view/BaseView.php");
require_once("lib/view/BreadCrumbView.php");

abstract class BaseWidget extends BaseView {

  protected $modelName;
  protected $internalView;
  protected $parentView;

  protected function initialize() {
    $this->modelName = null;
    $this->internalView = null;
    $this->parentView = null;

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
    return $this;
  }

  protected function postRun() {
    return $this;
  }

}

?>