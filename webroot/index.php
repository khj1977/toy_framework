<?php
  set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

  require_once("lib/TheWorld.php");
  require_once("lib/Dispatcher.php");

  TheWorld::instance()->initialize();

  $dispatcher = new Dispatcher();

  $dispatcher->dispatch();

?>