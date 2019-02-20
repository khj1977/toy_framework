<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/RSS.php");

class TestRSS extends BaseUnitTest {

  public function __construct() {
    // print("TestRSS has been made.\n");

    return true;
  }

  public function test_rssLoad() {
    $path = Util::realpath(dirname(__FILE__) . "/../input_files/dummy_rss.xml");
    $rss = new RSS();
    $rss->load($path);

    $children = $rss->getChildren();
    foreach($children as $child) {
      echo $child->getName() . "\n";
    }
  }

  public function test_child_depth() {
    $path = Util::realpath(dirname(__FILE__) . "/../input_files/dummy_rss.xml");
    $rss = new RSS();
    $rss->load($path);

    $children = $rss->getChildren();
    $child = $children[2];
    $subChildren = $child->getChildren();
    foreach($subChildren as $child) {
      echo $child->getName() . "\n";
    }
  }

  /*
  public function test_foo() {
    echo "test_foo() has been called.\n";
  }

  public function test_bar() {
    echo "test_bar() has been called.\n";
  }
  */

}

$test = new TestRSS();
$test->runTests();

?>
