<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/util/AnonClass.php");
require_once("lib/KORM.php");
require_once("lib/TheWorld.php");

class TestKORM extends BaseUnitTest {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function preRun() {
    $this->debugStream->setFlag(true);
  }

  public function test_init() {
    $korm = new KORM("test_table");
    $korm->autoSetColNames();

    $this->ds->println("KORM_AUTO:");
    $this->ds->vd($korm);

    return true;
  }

  public function test_statement() {
    $statement = TheWorld::instance()->slave->prepare("SELECT * FROM test_table");
    $statement->execute(array());

    while($row = $statement->fetch()) {
      $this->debugStream->println("statement row: ");
      $this->debugStream->varDump($row);
    }
  }

  public function test_fetch() {
    $korm = new KORM("test_table");
    // $korm->autoSetColNames();
    $objects = $korm->fetch();

    // $this->debugStream->println("KORM OBJECTS: ");
    // $this->debugStream->varDump($objects);

    foreach($objects as $object) {
      $this->ds->pl("korm object: ");
      $this->ds->vd($object->id . " " . $object->getType("id"));
      $this->ds->vd($object->foo . " " . $object->getType("foo"));
      $this->ds->vd($object->bar . " " . $object->getType("bar"));
    }

    // $this->debugStream->varDump($objects);
    // $this->debugStream->varDump($korm);

    return true;
  }

}

?>