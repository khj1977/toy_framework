<?php

require_once("lib/BaseClass.php");

class RenderingArea extends BaseClass {

  public function renderOn($html) {
    print($html);
  }

}

?>