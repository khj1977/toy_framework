<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/scaffold/BaseTable.php");
require_once("lib/scaffold/DBCol.php");

// Note: file and class name of this file will be changed considering
// some comments on TableToFiledMapper.php.

// MySQL describe => col definition => return this info => mainly, use raw data for scaffold

class MySQLTable extends BaseTable {

  protected $colProps;

  public function __construct($tableName) {
    parent::__construct($tableName);

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    $this->colProps = $this->getRawColNames();

    return $this;
  }

  // Format of $rawDatas
  // "col_name1" => data1, "col_name2" => data2, "col_name3" => data3, .....
  // $rawData is just a hash which may be result of query from MyPdo.
  public function getCols($rawData) {
    $dbCols = array();

    // each raw contains several cols
    foreach($rawData as $colName => $data) {
      $colProp = $this->colProps[$colName];

      $dbCol = new DBCol();


      // protected $colName;
      // protected $colType;
      // protected $colVal;
      $dbCol->col_name = $colName;
      $dbCol->col_type = $colProp["type"];
      $dbCol->col_val = $data;
      $dbCol->is_null = $isNull;

      $dbCols[] = $dbCol;
    }

    return $dbCols;
  }

  protected function getRawColProps() {
      $sql = sprintf("describe %s", $this->tableName);
      $rows = $this->slave->query($sql);

      $colProps = array();
      foreach($rows as $row) {
        $actualColName = $row["Field"];
        $type = $row["Type"];
        $isNull = $row["Null"];

        $colProps[$actualColName] = array("field" => $actualColName, "type" => $type, "is_null" => $isNull);
      }

      return $colProps;
  }

}

?>