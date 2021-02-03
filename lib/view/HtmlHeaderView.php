<?php

require_once("lib/view/BaseView.php");

class HtmlHeaderView extends BaseView {

  protected $cols;

  protected function initialize() {
    $this->cols = array();

    return $this;
  }

  public function push($col) {
    $this->cols[] = $col;

    return $this;
  }

  public function getKeys() {
    $keys = array();
    foreach($this->cols as $col) {
      $key = $col->getName();
      $keys[] = $key;
    }

    return $keys;
  }

  public function render() {
    $keys = $this->getKeys();
    $html = "<tr>";
    foreach($keys as $key) {
      $html = $html . "<td>" . $key . "</td>";
    }
    $html = $html . "</tr>";

    return $html;
  }
}

?>