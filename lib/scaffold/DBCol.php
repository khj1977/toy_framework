<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

class DBCol extends BaseClass {

  // debug
  // refactor the following to use setter/getter of BaseClass not instance val;
  // protected $colName;
  // protected $colType;
  // protected $colVal;

  // protected $isNull;
  // end of debug

  // model not view. view will be HTMLField or something like that.
  // $field will fetch val and other info from instance of this class.
  protected $field;

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    $this->setAccessible("col_name")->setAccessible("col_type")->setAccessible("col_val")->
      setAccessible("is_null");

    $this->field = null;

    return $this;    
  }

  public function setField($aField) {
    $this->field = $aField;

    return $this;
  }

}

?>