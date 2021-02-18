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

  public function test_simpleFetch() {
    // KORM::setTableName("employee_list");
    // KORM::initialize();

    $orms = EmployeeListModel::fetch();
    foreach($orms->generator() as $orm) {
      Util::println("id: " . $orm->id . " : " . $orm->first_name);
    }

    return true;
  }

  public function test_simpleJoin() {
    KORM::initialize();
    KORM::setTableName("company");
    
    // KORM::setBelongTo("PrefectureModel");
    KORM::setBelongWith(array("belong_to" => "PrefectureModel", "from_key" => "prefecture_id", "to_key" => "id"));

    $orms = KORM::fetch();

    $orms->each(function($orm) {
      Util::println("cname: " . $orm->name . " pname: " . $orm->PrefectureModel->name);
      // Util::println("cname: " . $orm->name);
    });
    
    return true;
  }
  

}