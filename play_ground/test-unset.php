<?php

$a = array("foo" => 6, "bar" => 4, "foo2" => 3);
var_dump($a);

foreach($a as $key => $val) {
  unset($a[$key]);
}

var_dump($a);

?>