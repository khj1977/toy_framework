<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

$str = "model_test_foo_model";
$subStr = "_model";

$subStrIndex = 0;
$subChar = $subStr[$subStrIndex];
$len = strlen($str);

for($i = 0; $i < $len; ++$i) {
  // printf("%d %d %d %d\n", $i, $len, $subStrIndex, $subStrStartIndex);
  $chr = $str[$i];
  // printf("%s %s\n", $chr, $subChar);
  if (strcmp($chr, $subChar) == 0) {
    if ($subStrIndex == 0) {
      $subStrIndex = $i;
      $subStrStartIndex = $i;
    }
    if ($i == ($len - 1)) {
      /*
      echo substr($str, 0, $len - $subStrStartIndex + 1);
      exit;
      */
    }
    ++$subStrIndex;
    $subChar = $subStr[$subStrIndex];
  }
  else {
    $subStrIndex = 0;
    $subChar = $subStr[$subStrIndex];
  }
}

echo substr($str, 0, $subStrStartIndex) . "\n";
// exit;

?>