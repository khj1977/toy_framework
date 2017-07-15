<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseOutputHandler.php");

class RSSOutputHandler {

  public function __construct() {
  }

  public function write($text) {
    printf("%s", $text);

    return $this;
  }

}

?>
