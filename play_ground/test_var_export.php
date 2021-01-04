<?php

class TestClass {
  public $foo;
  public $bar;
}

$obj = array();
$obj[] = 1;
$obj[] = 5;
$obj[] = 10;

$str = var_export($obj, true);
print("str: " . $str);

$obj2 = new TestClass();
$obj2->foo = "apple";
$obj2->bar = "orange";

$str2 = var_export($obj2, true);
print(" str2 " . $str2);

?>