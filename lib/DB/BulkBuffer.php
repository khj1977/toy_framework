<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class BulkBuffer extends BaseClass {

  protected $master;
  protected $tableName;
  protected $propsAsArray;
  protected $valsAsArrayOfArray;

  protected $th;
  protected $itr;

  public function __construct($tableName, $th) {
    parent::__construct();

    $this->tableName = $tableName;
    $this->th = $th;
    $this->itr = 0;

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->master = TheWorld::instance()->master;
    $this->propsAsArray = array();
    $this->valsAsArrayOfArray = array();

    return $this;
  }

  public function setProps($aPropsAsArray) {
    $this->propsAsArray = $aPropsAsArray;

    return $this;
  }

  public function push($aDataAsHash) {
    $valsAsArray = array();
    foreach($this->propsAsArray as $prop) {
      if (!array_key_exists($prop, $aDataAsHash)) {
        continue;
      }

      $data = $this->master->quote($aDataAsHash[$prop]);
      $valsAsArray[] = $data;
    }

    $this->valsAsArrayOfArray[] = $valsAsArray;

    $this->itr = $this->itr + 1;
    if ($this->itr === $this->th) {
      $this->exec();
      $this->itr = 0;
    }
    
    return $this;
  }

  // process insert with bulk buffer
  public function exec() {
    $sql = $this->constructQuery();

    return $this->master->bulkQuery($sql);
  }

  protected function constructQuery() {
    $sql = "INSERT INTO " . $this->tableName . " (";
    $n = count($this->propsAsArray);
    $i = 0;
    foreach($this->propsAsArray as $prop) {
      $sql = $sql . $prop;
      if ($i != ($n - 1)) {
        $sql = $sql . ",";
      }

      ++$i;
    }
    $sql = $sql . ") VALUES";

    $nnn = count($this->valsAsArrayOfArray);
    $kk = 0;
    foreach($this->valsAsArrayOfArray as $valsAsArray) {
      $sql = $sql . "(";

      $nn = count($valsAsArray);
      $k = 0;
      foreach($valsAsArray as $val) {
        $sql = $sql . $val;
        if ($k != ($nn - 1)) {
          $sql = $sql . ",";
        }

        ++$k;
      }
      $sql = $sql . ")";
      if ($kk != ($nnn - 1)) {
        $sql = $sql . ",";
      }
      ++$kk;
    }

    // debug
    // $this->debugStream->varDump($sql);
    // end of debug

    return $sql;
  }

}

?>