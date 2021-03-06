<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/util/Assert.php");
require_once("lib/scaffold/StringPair.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLConfirmElementFactory.php");
require_once("lib/KORM.php");
require_once("lib/TheWorld.php");
require_once("lib/util/Util.php");;

class TestConfirmScaffold extends BaseUnitTest {

  public function test_StringPair() {
    $baseKORM = new KORM("test_table");
    // debug
    // of call fetchOne()?
    $korms = $baseKORM->fetch(null, null, 1);
    // end of debug

    $stringPairs = array();
    $propNames = $korms[0]->getPropNames();
    foreach($korms->generator() as $korm) {
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