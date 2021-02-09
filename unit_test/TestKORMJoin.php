<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/KORM.php");
require_once("lib/BaseKORMModel.php");

class EmployeeListModel extends BaseKORMModel {

}

class CompanyModel extends BaseKORMModel {

}

class PrefectureModel extends BaseKORMModel {

}

class TestKORMJoin extends BaseUnitTest {

  /*
  public function test_simpleFetch() {
    // KORM::setTableName("employee_list");
    // KORM::initialize();

    $orms = EmployeeListModel::fetch();
    foreach($orms as $orm) {
      Util::println("id: " . $orm->id);
    }

    return true;
  }
  */

  public function test_simpleJoin() {
    KORM::setTableName("company");
    
    KORM::setBelongTo("PrefectureModel");
    KORM::setBelongWith(array("from_key" => "prefecture_id", "to_key" => "id"));
    KORM::initialize();

    $orms = KORM::fetch();
    foreach($orms as $orm) {
      Util::println("cname: " . $orm->name . " pname: " . $orm->joined->name);
    }

    return true;
  }

}