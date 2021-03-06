<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/util/Util.php");;

class DBCol extends BaseClass {

  // model not view. view will be HTMLField or something like that.
  // $field will fetch val and other info from instance of this class.
  protected $name;
  protected $val;
  protected $type;
  protected $key;

  protected $htmlFactory;
  protected $tableName;

  public function __construct() {
    parent::__construct();
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // debug
    // for debug purpose, off now.
    // no effect to just apply get/set
    /*
    $this->setAccessible("col_name")->setAccessible("col_type")->setAccessible("col_val")->
      setAccessible("is_null");
    */
    // end of debug

    $this->name = null;
    $this->val = null;
    $this->type = null;
    $this->type = null;

    $this->htmlFactory = null;
    $this->tableName = null;

    return $this;    
  }

  public function setHTMLFactory($aFactory) {
    $this->htmlFactory = $aFactory;

    return $this;
  }

  public function setTableName($tableName) {
    $this->tableName = $tableName;

    return $this;
  }

  public function setTypeNameValTriple($name, $type, $val) {
    $this->type = Util::convertMySQLType($type);
    $this->name = $name;
    $this->val = $val;

    return $this;
  }

  public function getName() {
    return $this->name;
  }

  public function getVal() {
    return $this->val;
  }

  public function getType() {
    return $this->type;
  }

  public function getKey() {
    return $this->key;
  }

  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  public function setVal($val) {
    $this->val = $val;

    return $this;
  }

  public function setType($type) {
    // debug
    // $this->type = $type;
    $this->type = Util::convertMySQLType($type);
    // end of debug

    return $this;
  }

  public function setKey($key) {
    $this->key = $key;

    return $this;
  }

  public function isHidden() {
    if ($this->name === "id" && $this->type === "int") {
      return true;
    }
    // select menu not hidden.
    /*
    else if (preg_match("/.*_id/", $this->name) === 1) {
      return true;
    }
    */

    return false;
  }

  public function toString() {
    $str = $this->name . " : " . $this->type ." : " . $this->val;

    return $str;
  }

  public function render() {
    return $this->htmlFactory->make($this->tableName, $this);
  }
  
  public function getPropsAsHash() {
    return array(
      "name" => $this->name,
      "type" => $this->type,
      "val" => $this->val
    );
  }

}

?>