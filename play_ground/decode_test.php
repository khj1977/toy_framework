<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

if ($argc != 2) {
  printf("usage: prog path\n");
  exit;
}

$path = $argv[1];

$stream = fopen($path, "r");
$input = "";
while($line = rtrim(fgets($stream))) {
  $input = $input . "\n" . $line;
}

$decoded = htmlspecialchars_decode($input);

print($decoded);

?>
