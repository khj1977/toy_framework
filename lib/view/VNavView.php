<?php

require_once("lib/view/BaseView.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class VNavView extends BaseView {

  protected $elements;

  protected function initialize() {
    $this->elements = KArray::new();

    return $this;
  }

  public function render() {
    // The following is dummy data from bootstrap document.
  /*
  $html = '<ul class="nav nav-pills flex-column">' . 
    '<li class="nav-item">' .
    '<a class="nav-link" href="#">Supermarket</a>' .
    '</li>' .
    '<li class="nav-item">' .
    '<a class="nav-link active" aria-current="page" href="#">Supermarche</a>' .
    '</li>' .
    '<li class="nav-item">' .
    '<a class="nav-link" href="#">Grocery</a>' .
    '</li>' .
    '<li class="nav-item">' .
    '<a class="nav-link" href="#" tabindex="-1">Epicerie</a>' .
    '</li>' .
    '</ul>';
    */

    // $html = '<ul class="nav nav-pills flex-column">';
    $html = '<ul class="nav nav-tabs">';
    foreach($this->elements->generator() as $element) {
      $html = $html . '<li class="nav-item">';
      // debug
      // little bit ugly.
      if ($element->get("is_active") === true) {
        $klass = "nav-link active";
        $aria = true;
      }
      else {
        $klass = "nav-link";
        $aria = false;
      }
      // end of debug

      if ($aria === false) {
        $html = $html . sprintf('<a class="%s" href="%s">%s</a>', $klass, $element->get("href"), $element->get("desc"));
      }
      else {
        $html = $html . sprintf('<a class="%s" aria-current="page" href="%s">%s</a>', $klass, $element->get("href"), $element->get("desc"));
      }
      $html = $html . '</li>';
    }

    $html = $html . '</ul>';

    return $html;
  }

  public function pushElement($href, $desc, $isActive) {
    $this->elements->push(KHash::new()->set("href", $href)->set("desc", $desc)->set("is_active", $isActive));

    return $this;
  }

  public function push($href, $desc, $isActive) {
    return $this->pushElement($href, $desc, $isActive);
  }

}

?>