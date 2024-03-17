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

  protected $myName;
  protected $myKlassName;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->myName = null;
    $this->myKlassName = null;

    return $this;
  }

  public function setMyName($myName) {
    $this->myName = $myName;

    return $this;
  }

  public function getMyName() {
    if ($this->getMyName() === null) {
      return "";
    }

    return $this->myName;
  }

  public function setMyKlass($klassName) {
    $this->myKlassName = $klassName;

    return $this;
  }

  public function getMyKlassName() {
    if ($this->myKlassName === null) {
      return "";
    }

    return $this->myKlassName;
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