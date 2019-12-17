<?php

// debug
// better way to set path of require_once provided by framework. This code is not under control of framework
set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));
require_once("lib/util/Util.php");
// end of debug

print(Util::upperCamelToUnderScore("this_is_test_of_util"));

?>