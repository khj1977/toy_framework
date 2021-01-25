<?php

class Foo {

  public function aMethod() {
    // test by not get_class()
    print("class name: " . get_called_class() . "\n");
  }

}

class Bar extends Foo {

}

$obj = new Foo();
$obj->aMethod();

$obj2 = new Bar();
$obj2->aMethod();

?>