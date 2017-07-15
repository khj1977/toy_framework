<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

// specific to MySQL. Not use Factory for generalization.
require_once("lib/scaffold/MySQLTable.php");

// Table => cols (assign names) => DBRawCol and DBRawCols as collection
// cols and field=> map col inside DBRawCol with field. field will be represented by HTMLField
// (view)
// which is base class and has sub class which represents kind of field (by configfile).
// field grouping (by config file using assigned names) => will repesented by HTMLFieldGroup
// and that group will be made by some HTMLField manipulation object whose class name is Algorithm => 
// field action will be realized using filter. filter call other POPO.

// position of field (not sure yet)

// basic classes
// DBRawCol, DBRawCols as collection or just array
// DBCol <=> Field which is kind of view which has method something like render and obtain data from
// DBCol. Actually, DBCol is close to model in the sense of MVC.
// HTMLField and sub classes
// HTMLFieldGroupConfig, which is config file and group of HTMLField which is HTMLFieldGroup on above paragraph.
// HTMLFieldManipulationAlgorithm => just for dynamic change of grouping
// Fileter for action and Field


class TableToFieldMapper extends BaseClass {


  public function __construct() {
    $this->initialize();

    return $this;
  }

  protected function initialize() {
    return $this;
  }

  // $rawObtainer is anon-func not closure which executes sql query and result raw data.
  // anon-func is used but strategy class is not used since there should be several number of
  // class for this use case.
  // It will be recommended to define anon func at one class file for modurarity and to make
  // maintenance of code easy. Note that the number of class will be number of table * number
  // of strategy.
  public function map($tableName, $rawObtainer, $fieldFactory) {
    $table = new MySQLTable($tableName);

    $raw = $rawObtainer($tableName);
    $cols = $table->getCols($raw);

    // assign a field to each cols.
    $modifiedCols = array();
    foreach($cols as $col) {
      $anField = $fieldFactory->make($tableName, $col);
      $col->setField($anField);

      $modifiedCols[] = $col;
    }

    return $modifiedCols;
  }

}

?>