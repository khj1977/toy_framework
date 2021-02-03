<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/view/BaseView.php");

class SimpleRowsView extends BaseView {

  protected $htmlRowHeader;
  protected $htmlRows;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->htmlRows = array();
    $this->htmlRowHeader = null;

    return $this;
  }

  public function push($htmlElement) {
    $this->htmlRows[] = $htmlElement;

    return $this;
  }

  public function pushHtmlHeader($htmlElement) {
    $this->htmlRowHeader = $htmlElement;

    return $this;
  }

  public function render() {
    // $html = "<table>";
    $html = '<table class="table table-striped">';
    // $htmlRow = $this->htmlRows[0];
    if ($this->htmlRowHeader !== null) {
      $html = $html . $this->htmlRowHeader->render();
    }

    foreach($this->htmlRows as $htmlRow) {
      if ($htmlRow->isHidden()) {
        continue;
      }
      
      $html = $html . $htmlRow->render();
    }

    $html = $html . "</table>";

    return $html;
  }

}

?>