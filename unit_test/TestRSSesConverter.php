<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/RSS.php");
require_once("lib/RSSesConverter.php");

class TestRSSesConverter extends BaseUnitTest {

  public function __construct() {
  }

  public function test_convert() {
    mb_internal_encoding("UTF-8");
    // echo "foo:" . mb_internal_encoding("UTF-8") . "\n";
    // var_dump(mb_list_encodings());

    // debug
    // put it on TheWorld
    set_error_handler(function($errorNo, $errorStr) {
        // debug
        return;
        // end of debug
        $message = sprintf("TheWorld::setErrorHandler(): %d\t%s", $errorNo, $errorStr);
        throw new Exception($message);
      } );
    // end of debug

    $path = realpath(dirname(__FILE__) . "/../input_files/foo.xml");
    $rss = new RSS();
    $rss->load($path);

    try {
      $converter = new RSSesConverter();
      $converter->convert($rss);

      echo $rss . "\n";
    }
    catch(Exception $ex) {
      print($ex->getMessage() . "\n");

      exit;
    }
  }

}

$test = new TestRSSesConverter();
$test->runTests();

?>
