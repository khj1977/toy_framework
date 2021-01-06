<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/TheWorld.php");
require_once("lib/scaffold/sub_view/BaseScaffoldView.php");

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

  public function hasHeader() {
    return true;
  }

  public function render() {
    $router = TheWorld::instance()->router;
    $html = "<tr>";
    $i = 0;
    foreach($this->cols as $col) {
      if ($i == 0) {
        // debug
        // critical for scaffold.
        // not appropriate view of edit
        $html = $html . "<td>" . sprintf("<a href='/index.php?m=%s&c=%s&a=edit&id=%s'>", $router->getModule(), $router->getController(), $col->getVal()) . $col->getVal() . "</a>" . "</td>";
        // end of debug
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