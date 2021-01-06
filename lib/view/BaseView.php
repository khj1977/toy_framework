<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

/*
if ($htmlRow->hasHeader()) {
  $html = $html . $htmlRow->renderHeader();
}
foreach($this->htmlRows as $htmlRow) {
  if ($htmlRow->isHidden()) {
     continue;
  }
  
  $html = $html . $htmlRow->render();
*/

abstract class BaseView extends BaseClass {

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  abstract public function render();

  public function hasHeader() {
    return false;
  }

  public function renderHeader() {
    throw new KException($this->getKlassName() . ": this method is not implemented in this class.");
  }

  public function isHidden() {
    return true;
  }

}

?>