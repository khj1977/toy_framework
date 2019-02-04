<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

$str = "ModelTestModel";
$matches = array();

$err = preg_match("/([A-Z][a-z]*)*/", $str, $matches);

$result = "";
$len = strlen($str);
for($i = 0; $i < $len; ++$i) {
  $chr = $str[$i];
  if (preg_match("/[A-Z]/", $chr) != 0) {
    $chr = lcfirst($chr);
    if ($i != 0) {
      $result = $result . "_" . $chr;
    }
    else {
      $result = $result . $chr;
    }
  }
  else {
    $result = $result . $chr;
  }
}

print($result . "\n");


?>