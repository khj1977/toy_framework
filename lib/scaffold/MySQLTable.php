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

    $this->debugStream->varDump("foo4");
    parent::__construct($tableName);
    $this->debugStream->varDump("foo5");

    return $this;
  }

  protected function initialize() {
    parent::initialize();
    // The following method is declaird by BaseTable
    // as abstract protected method.
    // So it should be implemented for MySQL
    // specific.
    // $this->colProps = $this->getRawColNames();

    return $this;
  }

  // Return collection or array of DBCol object.
  public function getDBCols($limit = null) {
    $this->colProps = $this->getRawColNames();

    $rawDatas = $this->getRawDatas($limit);
    // debug
    // $this->debugStream->varDump($rawDatas);
    // end of debug
    $dbCols = $this->xgetCols($rawDatas);

    return $dbCols;
  }

  public function getColProps() {
    return $this->colProps;
  }

  protected function getRawDatas($limit) {
    // $colNames = $this->getRawColNames();
    // fetch all data. so, for some cases,
    // customized version of this method should
    // be used to limit number of rows.

    // Should be full-filled.
    $colDatas = array();

    $sql = "SELECT * FROM " . $this->tableName;
    if ($limit != null) {
      $sql = $sql . " LIMIT " . $limit;
    }

    $statement = TheWorld::instance()->slave->prepare($sql);
    $statement->execute(array());
    while($row = $statement->fetch()) {
      $colDatas[] = $row;
    }

    return $colDatas;
  }

  // Return collection or array of DBCol object.
  // Format of $rawDatas
  // "col_name1" => data1, "col_name2" => data2, "col_name3" => data3, .....
  // $rawData is just a hash which may be result of query from MyPdo.

  // $rawData is array of hash. which is
  // returned by MySQL PDO.
  protected function xgetCols($rawDatas) {
    $rows = array();

    $this->debugStream->varDump($rawDatas);

    // each raw contains several cols
    // row
    foreach($rawDatas as $rawData) {
      // col
      $dbCols = array();
      foreach($rawData as $colName => $val) {
        if (preg_match("/^[0-9]*$/", $colName)) {
          continue;
        }

        // $colProps[$actualColName] = array("field" => $actualColName, "type" => $type, "is_null" => $isNull);
        if (!array_key_exists($colName, $this->colProps)) {
          throw new KException("MySQLTable::xgetCols(): this name is not there in colProp: " . $colName);
        }
        $colProp = $this->colProps[$colName];

        // debug
        $this->debugStream->varDump("MySQLTable");
        $this->debugStream->varDump($colName);
        // end of debug

        $dbCol = new DBCol();

        /*
        $dbCol->col_name = $colName;
        $dbCol->col_type = $colProp["type"];
        $dbCol->col_val = $data;
        $dbCol->is_null = $colProp["is_null"];
        */
        $dbCol->setNameValPair($colName, $val);
        $dbCols[] = $dbCol;
      }
      // $dbCols == row.
      $rows[] = $dbCols;
  }

    return $rows;
  }

  protected function getRawColNames() {
      $sql = sprintf("describe %s", $this->tableName);
      // debug
      // refactor to user query().
      $statement = $this->slave->prepare($sql);
      $statement->execute(array());
      $rows = $statement->fetchAll();
      // end of debug

      // debug
      // TheWorld::instance()->debugStream->varDump($rows);
      // end of debug
      
      $colProps = array();
      foreach($rows as $row) {
        // $dbCol->col_name = $colName;
        // $dbCol->col_type = $colProp["type"];
        // $dbCol->col_val = $data;
        // $dbCol->is_null = $colProp["is_null"];

        $actualColName = $row["Field"];
        $type = $row["Type"];
        $isNull = $row["Null"];

        $colProps[$actualColName] = array("field" => $actualColName, "type" => $type, "is_null" => $isNull);
      }

      return $colProps;
  }

}

?>