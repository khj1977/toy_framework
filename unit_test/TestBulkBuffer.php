<?php

require_once(realpath(dirname(__FILE__) . "/../lib/BaseUnitTest.php"));
require_once("lib/DB/BulkBuffer.php");

class TestBulkBuffer extends BaseUnitTest {

  public function test_BulkBuffer() {
    try {
      $buffer = new BulkBuffer("test_table", 50);
      $buffer->setProps(array("foo", "bar", "product_id"));
      for($i = 0; $i < 100; ++$i) {
        $suffix = $i;
       $buffer->push(array("foo" => "apple_pie " . $suffix, "bar" => $i + 1, "product_id" => $i));
      }

      $this->setSuccessed();
    }
    catch(Exception $e) {
      $this->setFailed();
    }
    
  }

    // $buffer->exec();
  }

}

?>