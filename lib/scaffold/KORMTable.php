<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KORM.php");
require_once("lib/scaffold/BaseTable.php");
require_once("lib/scaffold/DBCol.php");
require_once("lib/KException.php");
require_once("lib/TheWorld.php");

class KORMTable extends BaseTable {

  protected $modelName;
  protected $orm;

  public function __construct($modelName) {
    $this->modelName = $modelName;

    $baseDir = TheWorld::instance()->getBaseDir();
    $moduleName = TheWorld::instance()->router->getModule();

    $modelPath = Util::realpath(sprintf(
      "%s/apps/%s/models/%s.php", 
      $baseDir, 
      $moduleName, 
      $this->modelName
    ));
    
    // debug
    // check whether exist file and anti-directory traversal
    // end of debug
    require_once($modelPath);

    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    parent::__construct($tableName);

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  // where = array(arrray("col" => $col, "cond" => $cond)). where cond = num
  public function getDBCols($limit = null, $where = null) {
    // $baseOrm = new KORM($this->tableName);
    $modelName = $this->modelName;
    // $baseOrm = new $modelName();
    // $orms = $baseOrm->fetch($where, null, $limit);
    $orms = $modelName::fetch($where, null, $limit);

    // $this->ds->vd($orms);
    
    // obtain col names and types
    // obtain val from col name and orm.
    // then assign to db cols.
    $rows = array();
    foreach($orms->generator() as $orm) {
      $dbCols = array();
      $props = $orm->getPropNames();
      foreach($props->generator() as $prop) {
        $type = $orm->getType($prop);
        $key = $orm->getKey($prop);
        $val = $orm->$prop;

        $dbCol = new DBCol();
        $dbCol->setTypeNameValTriple($prop, $type, $val)->setKey($key);

        $dbCols[] = $dbCol;
      }

      $rows[] = $dbCols;
    }

    return $rows;
  }

  public function getDBPropsWithEmptyData() {
    $modelName = $this->modelName;
    // $baseOrm = new $modelName();
    // $orms = $baseOrm->fetch($where, null, $limit);
    $modelName::initialize();
    $this->orm = new $modelName();

    $props = $this->orm->getPropNames();

    $rows = array();

    $dbCols = array();
    $props = $this->orm->getPropNames();
    foreach($props->generator() as $prop) {
      $type = $this->orm->getType($prop);
      $key = $this->orm->getKey($prop);
      // $val = $orm->$prop;
      $val = "";

      $dbCol = new DBCol();
      $dbCol->setTypeNameValTriple($prop, $type, $val)->setKey($key);

      $dbCols[] = $dbCol;
    }

    return $dbCols;
  }

  public function getDBPropsWithWithEmptyDataByHash() {
    $modelName = $this->modelName;
    // $baseOrm = new $modelName();
    // $orms = $baseOrm->fetch($where, null, $limit);
    $modelName::initialize();
    $this->orm = new $modelName();

    $props = $orm->getPropNames();

    $rows = array();

    $dbCols = array();
    $props = $this->orm->getPropNames();
    foreach($props->generator() as $prop) {
      $type = $this->orm->getType($prop);
      $key = $this->orm->getKey($prop);
      // $val = $orm->$prop;
      $val = "";

      $dbCol = new DBCol();
      $dbCol->setTypeNameValTriple($prop, $type, $val)->setKey($key);

      $dbCols[$prop] = $dbCol;
    }

    return $dbCols;
  }

  public function getORM() {
    return $this->orm;
  }

  protected function getRawColNames() {
    throw new KException("KORMTable::getRawColNames(): this method has not been implemented yet.");
  }

}

?>