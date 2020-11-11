<?php

$matches = array();
preg_match("/foo/", "This is regex", $matches);

var_dump($matches);

?>