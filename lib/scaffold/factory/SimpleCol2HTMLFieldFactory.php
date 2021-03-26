<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class SimpleCol2HTMLFieldFactory extends BaseClass {

  protected $orms;

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function setORM($orm) {
    $this->orm = $orm;

    return $this;
  }

  public function make($tableName, $col) {
    // $type = $this->convertType($col->getType());
    $type = $col->getType();

    // debug
    // handle key
    // if key is mul, which is fk, load master data, and make select button with default value.
    // end of debug

    $matched = array();
    if ($col->getName() === "id" && $type == "int") {
      $html = sprintf("<input class='form-control' type='hidden' name='%s' value='%s'>", $col->getName(), $col->getVal());
    }
    else if (preg_match("/(.*)_id/", $col->getName(), $matched) === 1 && $type == "int") {
      // debug
      // impl select menu
      // from col name, such as company_kind_id generate class name like 
      // CompanyKindModel ,and then, access to ORM, and then, make select menu by
      // that joined data.
      // <option value="foo" selected>foo</option>
      $joinedKlassName = $matched[1];
      $joinedModelName = Util::underscoreToUpperCamel($joinedKlassName . "Model");
      $joinedModels = $joinedModelName::fetch();
      $html = sprintf("<select name='%s'>", $this->orm->getKlassName());
      foreach($joinedModels->generator() as $model) {
        // id and name prop is ConC.
        $html = $html . " " . sprintf("<option value='%s' class='form-control' type='text' name='%s' value='%s' selected>%s</option>", $model->id, $model->name, $model->name, $model->name);
      }
      $html = $html . " " . "</select>";
      // end of debug
    }
    else if ($type === "int") {
        $html = sprintf("<input class='form-control' type='numeric' name='%s' value='%s'>", $col->getName(), $col->getVal());
    }
    else if ($type === "varchar") {
        $html = sprintf("<input class='form-control' type='text' name='%s' value='%s'>", $col->getName(), $col->getVal());
    }
    else {
      throw new KException("Col2HTMLFactory::make(): no match of type to make HTML: " . $type);
    }

    return $html;
  }

  
  protected function convertType($rawType) {
    if (preg_match("/int.*/", $rawType) == 1) {
      return "int";
    }
    else if (preg_match("/varchar.*/", $rawType)) {
      return "varchar";
    }
   
    return $rawType;
  }
  
}

?>