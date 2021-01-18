<?php

require_once("lib/view/BaseView.php");
require_once("lib/view/BreadCrumbView.php");

abstract class BaseWidget extends BaseView {

  protected $modelName;
  protected $internalView;

  protected function initialize() {
    $this->modelName = null;
    $this->internalView = null;

    return $this;
  }

  public function setModelName($modelName) {
    $this->modelName = $modelName;

    return $this;
  }

  public function setView($view) {
    $this->internalView = $view;

    return $this;
  }

  public function render() {
    return $this->internalView->render();
  }

  protected function preExecute() {
    return $this;
  }

  protected function postExecute() {
    return $this;
  }

}

?>