<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/view/BaseView.php");
require_once("lib/Util.php");

class SimpleView extends BaseView {

  protected $title;
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

  public function setTitle($title) {
    $this->title = $title;

    return $this;
  }

  public function addSubView($aView) {
    $this->subViews[] = $aView;

    return $this;
  }

  public function render() {
    if ($this->title != null) {
      Util::println("<h1>" . $this->title . "</h1>");
    }
    foreach($this->subViews as $subView) {
      // $subView->render();
      print($subView->render() . "</br>");
    }

    return $this;
  }

}

?>