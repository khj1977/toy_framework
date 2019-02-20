<?php


set_include_path(get_include_path() . "" . PATH_SEPARATOR . Util::realpath(dirname(__FILE__) . "/../"));
require_once("lib/util/Util.php");

$err = Util::realpath(__FILE__ . "/foo.php");
var_dump($err);

?>