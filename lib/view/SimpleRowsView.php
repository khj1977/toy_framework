<?php

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
    $html = "<table>";
    foreach($this->htmlRows as $htmlRow) {
      $html = $html . $htmlRow->toHTML() . "</br>";
    }
    $html = $html . "</table>";

    return $html;
  }

}

?>