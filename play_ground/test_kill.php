<?php

var_dump($argv);

$pid = $argv[1];

posix_kill($pid, SIGHUP);

?>