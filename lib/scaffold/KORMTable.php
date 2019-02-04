<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KORM.php");
require_once("lib/scaffold/BaseTable.php");
require_once("lib/scaffold/DBCol.php");
require_once("lib/KException.php");

class KORMTable extends BaseTable {

  public function __construct($tableName) {
    parent::__construct($tableName);
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  // where = array(arrray("col" => $col, "cond" => $cond)). where cond = num
  public function getDBCols($limit = null, $where = null) {
    $baseOrm = new KORM($this->tableName);
    $orms = $baseOrm->fetch($where, null, $limit);

    $this->ds->vd($orms);
    // obtain col names and types
    // obtain val from col name and orm.
    // then assign to db cols.
    $rows = array();
    foreach($orms as $orm) {
      $dbCols = array();
      $props = $orm->getPropNames();
      foreach($props as $prop) {
        $type = $orm->getType($prop);
        $val = $orm->$prop;

        $dbCol = new DBCol();
        $dbCol->setTypeNameValTriple($prop, $type, $val);

        $dbCols[] = $dbCol;
      }

      $rows[] = $dbCols;
    }

    return $rows;
  }

  protected function getRawColNames() {
    throw new KException("KORMTable::getRawColNames(): this method has not been implemented yet.");
  }

}

?>