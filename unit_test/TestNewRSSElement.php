<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/RSS.php");

class TestNewRSSElement extends BaseUnitTest {

  public function __construct() {
  }

  public function test_load() {
    return false;

    $path = realpath(dirname(__FILE__) . "/../input_files/dummy_rss.xml");
    $rss = new RSS();
    $rss->load($path);

    // var_dump($rss->obtainRootNode());

    $children = $rss->getChildren();

    // var_dump($children);

    foreach($children as $child) {
      echo $child->tagName . "\n";
    }

    return true;
  }

  public function test_mod() {
    $path = realpath(dirname(__FILE__) . "/../input_files/dummy_rss.xml");
    $rss = new RSS();
    $rss->load($path);

    // var_dump($rss->obtainRootNode());

    $children = $rss->getChildren();

    // var_dump($children);

    foreach($children as $child) {
      // echo $child->tagName . "\n";
      echo "has: " . $child->hasChildren() . "\n";
      echo "text content: " . $child->testTextContent() . "\n";
      echo "node value: " . $child->testNodeValue() . "\n";
      if ($child->hasChildren()) {
         continue;
      }
      
      $child->setInnerText("mod_by_unit_test: " . $child->getInnerText());
      echo "conv: " . $child->getInnerText() . "\n";

      // echo $child;
      // echo "\n";
    }

    echo $rss . "\n";

    return true;
  }


}

$test = new TestNewRSSElement();
$test->runTests();

?>
