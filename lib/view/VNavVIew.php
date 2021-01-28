<?php

require_once("lib/view/BaseView.php");

class VNavView extends BaseView {

  public function render() {
    // The following is dummy data from bootstrap document.
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

    return $html;
  }

}

?>