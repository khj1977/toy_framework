<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class ScaffoldTableRowView extends BaseScaffoldView {

  protected $cols;

  protected function initialize() {
    parent::initialize();

    $this->cols = array();
  }

  public function push($col) {
    $this->cols[] = $col;
  }

  public function isHidden() {
    return false;
  }

  public function getKeys() {
    $keys = array();
    foreach($this->cols as $col) {
      $key = $col->getName();
      $keys[] = $key;
    }

    return $keys;
  }

  public function renderHeader() {
    $keys = $this->getKeys();
    $html = "<tr>";
    foreach($keys as $key) {
      $html = $html . "<td>" . $key . "</td>";
    }
    $html = $html . "</tr>";

    return $html;
  }

  public function render() {
    $html = "<tr>";
    $i = 0;
    foreach($this->cols as $col) {
      if ($i == 0) {
        $html = $html . "<td>" . sprintf("<a href='/~HK/tfw/index.php?m=sample_app&c=sample&a=edit'&id=%s>", $col->getVal()) . $col->getVal() . "</a>" . "</td>";
      }
      else {
        $html = $html . "<td>" . $col->getVal() . "</td>";
      }
      ++$i;
    }
    $html = $html . "</tr>";

    return $html;
  }


}

?>