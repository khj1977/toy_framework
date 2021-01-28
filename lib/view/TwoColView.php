<?php

require_once("lib/view/BaseView.php");
require_once("lib/view/RawView.php");

class TwoColView extends BaseView {

  protected $leftColView;
  protected $rightColView;

  protected function initialize() {
    $this->leftColView = null;
    $this->rightColView = null;
  }

  public function setLeftColView($view) {
    // $rawView = RawView::new()->addSubView($view);
    $this->leftColView = $view;
  }

  public function setRightColView($view) {
    // $rawView = RawView::new()->addSubView($view);
    $this->rightColView = $view;
  }

  public function getLeftColView() {
    return $this->leftColView;
  }

  public function getRightColView() {
    return $this->rightColView;  
  }

  public function render() {
    $html = '<div class="row">' .
    '<div class="col-2">' .
    '%s' .
    '</div>' .
    '<div class=col-10>' .
    '%s' .
    '</div>' .
    '</div>';

    $html = sprintf($html, $this->leftColView->render(), $this->rightColView->render());

    return $html;
  }

}

?>