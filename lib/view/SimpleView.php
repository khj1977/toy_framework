<?php

require_once("lib/view/BaseView.php");

class SimpleView extends BaseView {

  protected $subViews;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->subViews = array();

    return $this;
  }

  public function addSubView($aView) {
    $this->subViews[] = $aView;

    return $this;
  }

  public function render() {
    foreach($this->subViews as $subView) {
      // $subView->render();
      print($subView->render() . "</br>");
    }

    return $this;
  }

}

?>