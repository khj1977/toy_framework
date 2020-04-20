<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class DataLoader extends BaseClass {

  public function __construct() {
    parent::__construct();

    TheWorld::instance()->debugStream->setFlag(true);

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  // file_name == table_name
  // each_line
  //   col_name1, col_name2, ...
  //   data1, data2, ...
  //   data21, data22, ...

  public function load($fileName) {
    $tableName = $this->fileNameToTableName($fileName);

    $stream = fopen($fileName, "r");
    if ($stream === false) {
      throw new KException("FileName: " . $fileName . " cannot be loaded");
    }
    $i = 0;
    while($line = chop(fgets($stream))) {
      // The first line of dat faile is definition of col.
      if ($i == 0) {
        $colNames = $this->getColNames($line);

        ++$i;
        continue;
      }

      $datas = explode(",", $line);
      $sql = $this->makeSQL($tableName, $colNames, $datas);

      // Do not user bulk insert.
      // Assume not so large data set.
      // If suffer to large data set, change to
      // user bulk insert.

      TheWorld::instance()->master->query($sql);

      ++$i;
    }
  }

  protected function fileNameToTableName($fileName) {
    $realFileName = basename($fileName);
    $splitted = explode(".", $realFileName);
    $tableName = $splitted[0];

    return $tableName;
  }

  protected function getColNames($line) {
    $splitted = explode(",", $line);

    return $splitted;
  }

  protected function makeSQL($tableName, $colNames, $datas) {
    $sql = "INSERT INTO " . $tableName . " (";
    $i = 0;
    $n = count($colNames);
    foreach($colNames as $colName) {
      $sql = $sql . $colName;
      if ($i != ($n - 1)) {
        $sql = $sql . ", ";
      }
      ++$i;
    }

    $sql = $sql . ") VALUES(";
    $i = 0;
    $n = count($datas);
    foreach($datas as $data) {
      $sql = $sql . TheWorld::instance()->master->quote($data);
      if ($i != ($n - 1)) {
        $sql = $sql . ", ";
      }
      ++$i;
    }
    $sql = $sql . ")";

    return $sql;
  }

}

?>