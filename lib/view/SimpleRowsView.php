<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/view/BaseView.php");

class SimpleRowsView extends BaseView {

  protected $htmlRows;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->htmlRows = array();

    return $this;
  }

  public function push($htmlElement) {
    $this->htmlRows[] = $htmlElement;

    return $this;
  }

  public function render() {
    // $html = "<table>";
    $html = '<table class="table table-striped">';
    if (count($this->htmlRows) != 0) {
      $htmlRow = $this->htmlRows[0];
      if ($htmlRow->hasHeader()) {
        $html = $html . $htmlRow->renderHeader();
      }
      foreach($this->htmlRows as $htmlRow) {
        if ($htmlRow->isHidden()) {
          continue;
        }
      
        $html = $html . $htmlRow->render();
      }
    }
    $html = $html . "</table>";

    return $html;
  }

}

?>