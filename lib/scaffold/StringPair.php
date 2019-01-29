<?php

require_once("lib/BaseClass.php");

class StringPair extends BaseClass {

  protected $key;
  protected $type;
  protected $val;

  protected $htmlFactory;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function setHTMLFactory($aFactory) {
    $this->htmlFactory = $aFactory;

    return $this;
  }

  public function setPair($key, $val) {
    $this->key = $key;
    $this->val = $val;

    return $this;
  }

  public function isHidden() {
    if ($this->key === "id") {
      return true;
    }

    return false;
  }

  public function getPair() {
    return array($key => $val);
  }

  public function renderHeader() {
    return "";
  }

  public function render() {
    return $this->htmlFactory->make($tableName, $this->key, $this->val);
  }

  public function toString() {
    return $this->key . " : " . $this->val;
  }

}

?>