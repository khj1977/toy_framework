<?php


require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/scaffold/StringPair.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLConfirmElementFactory.php");
require_once("lib/KORM.php");
require_once("lib/TheWorld.php");
require_once("lib/Util.php");

class TestConfirmScaffold extends BaseUnitTest {

  public function test_StringPair() {
    $baseKORM = new KORM("test_table");
    $korms = $baseKORM->fetch(null, null, 1);

    $stringPairs = array();
    $propNames = $korms[0]->getPropNames();
    foreach($korms as $korm) {
      foreach($propNames as $propName) {
        $stringPair = new StringPair();
        $stringPair->setPair($propName, $korm->$propName);

        $stringPairs[] = $stringPair;
      }
    }

    foreach($stringPairs as $stringPair) {
      Util::println($stringPair->toString());
    }

    return true;
  }

}

?>