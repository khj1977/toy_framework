<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KORM.php");
require_once("lib/scaffold/BaseTable.php");
require_once("lib/scaffold/DBCol.php");
require_once("lib/KException.php");
require_once("lib/TheWorld.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class KORMTable extends BaseTable {

  protected $modelName;

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

  public function getDBColsAsHash($limit = null, $where = null, $belongWiths = null) {
    $dbCols = $this->getDBCols($limit, $where, $belongWiths);

    $rows = new KArray();
    foreach($dbCols as $row) {
      $rowAsHash = new KHash();
      foreach($row as $dbCol) {
        // debug
        $rowAsHash->push($dbCol->getName(), $dbCol);
        // end of debug
      }
      $rows->push($rowAsHash);
    }

    return $rows;
  }

  // where = array(arrray("col" => $col, "cond" => $cond)). where cond = num
  public function getDBCols($limit = null, $where = null, $belongWiths = null) {
    // $baseOrm = new KORM($this->tableName);
    $modelName = $this->modelName;
    // $baseOrm = new $modelName();
    // $orms = $baseOrm->fetch($where, null, $limit);

    /*
    KORM::addBelongWith(array("belong_to" => "PrefectureModel", "from_key" => "prefecture_id", "to_key" => "id"));

    KORM::addBelongWith(array("belong_to" => "CompanyKindModel", "from_key" => "kind_id", "to_key" => "id"));

    KORM::fetch()->each(function($orm) {
      Util::println("cname: " . $orm->name . " pname: " . $orm->PrefectureModel->name . " : kind: " . $orm->CompanyKindModel->name);
    });
    */

    // debug
    // make ORM, get col names. If .*_id, make model name and set belongWith
    // end of debug
    $modelLoader = new ModelLoader();
    $modelLoader->load($modelName);
    if ($belongWiths != null) {
      foreach($belongWiths->generator() as $belongWith) {
        $modelName::addBelongWith($belongWith);
      }
    }
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

      // debug
      // handle situation of join.
      // KORM::addBelongWith(array("belong_to" => "CompanyKindModel", "from_key" => "kind_id", "to_key" => "id"));
      if ($belongWiths != null) {
        foreach($belongWiths->generator() as $belongWith) {
          $joinedModelName = $belongWith["belong_to"];
          $id = $orm->$joinedModelName->id;
          $name = $orm->$joinedModelName->name;

          // debug
          // $dbCol = DBCol::new()->setTypeNameValTriple($belongWith["from_key"], "int", $id)->setKey("");
          // $dbCols[] = $dbCol;
          // end of debug

          $dbCol = DBCol::new()->setTypeNameValTriple($belongWith["from_key"] . "_name", "varchar", $name)->setKey("");
          $dbCols[] = $dbCol;
        }
      }
      // end of debug

      $rows[] = $dbCols;
      // $rows = array_merge($rows, $dbCols);
    }

    return $rows;
  }

  public function setORM() {
    $modelName = $this->modelName;
    $modelName::initialize();
    $this->orm = new $modelName();

    return $this;
  }

  public function getDBPropsWithEmptyData($belongWiths = null) {
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

    if ($belongWiths != null) {
      foreach($belongWiths->generator() as $belongWith) {
        $modelName = $belongWith["belongTo"];

        $dbCol = DBCol::new()->setTypeNameValTriple($belongWith["from_key"], "int", "")->setKey("");
        $dbCols[] = $dbCol;

        $dbCol = DBCol::new()->setTypeNameValTriple($belongWith["from_key"] . "_name", "varchar", "")->setKey("");
      
        $dbCols[] = $dbCol;
      }
    }

    return $dbCols;
  }

  // debug
  // handle $belongWiths?
  // end of debug
  public function getDBPropsWithWithEmptyDataByHash() {
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

      $dbCols[$prop] = $dbCol;
    }

    return $dbCols;
  }

  protected function getRawColNames() {
    throw new KException("KORMTable::getRawColNames(): this method has not been implemented yet.");
  }

}

?>