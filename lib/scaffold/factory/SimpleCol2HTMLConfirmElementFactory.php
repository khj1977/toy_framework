<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class SimpleCol2HTMLConfirmElementFactory extends BaseClass {
  
  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  // key => val is key val of POST.
  public function make($tableName, $key, $val) {
    $html = sprintf("<tr><th>%s</th> <td>%s</td></tr>", $key, $val);

    return $html;
  }

}

?>