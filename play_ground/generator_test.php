<?php

class GeneratorTest {
  public function __construct() {

  }
  
  public function foo() {
    for($i = 0; $i < 10; ++$i) {
      yield $i;
    }

    return true;
  }

}

$obj = new GeneratorTest();
$gen = $obj->foo();
foreach($gen as $val) {
  print($val . "\n");
}

?>