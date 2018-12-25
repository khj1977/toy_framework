<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class SimpleCol2HTMLFieldFactory extends BaseClass {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  public function make($tableName, $col) {
    $type = $this->convertType($col->getType());

    if ($col->getName() === "id" && $type == "int") {
      $html = sprintf("<input type='hidden' name='%s' value='%s'>", $col->getName(), $col->getVal());
    }
    else if ($type === "int") {
        $html = sprintf("<input type='numeric' name='%s' value='%s'>", $col->getName(), $col->getVal());
    }
    else if ($type === "varchar") {
        $html = sprintf("<input type='text' name='%s' value='%s'>", $col->getName(), $col->getVal());
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