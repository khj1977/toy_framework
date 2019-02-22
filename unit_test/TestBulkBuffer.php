<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/DB/BulkBuffer.php");

class TestBulkBuffer extends BaseUnitTest {

  public function test_BulkBuffer() {
    $buffer = new BulkBuffer("test_table");
    $buffer->setProps(array("foo", "bar", "product_id"));
    for($i = 0; $i < 100; ++$i) {
      $suffix = $i;
      $buffer->push(array("foo" => "apple_orange " . $suffix, "bar" => $i + 1, "product_id" => $i));
    }

    $buffer->exec();
  }

}

?>