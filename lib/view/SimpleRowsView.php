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
      $this->ds->vd("is_hidden:");
      $this->ds->vd($htmlRow);
      $this->ds->vd($htmlRow->isHidden());
      if (!$htmlRow->isHidden()) {
         // continue;
         $html = $html . $htmlRow->toHTML() . "</br>";
      }
      // $html = $html . $htmlRow->toHTML() . "</br>";
    }
    $html = $html . "</table>";

    return $html;
  }

}

?>