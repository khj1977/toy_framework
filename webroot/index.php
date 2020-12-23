<?php
  set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

  require_once("lib/TheWorld.php");
  require_once("lib/SimpleDispatcher.php");

  TheWorld::instance()->initialize();

  $dispatcher = new SimpleDispatcher();

  $dispatcher->dispatch();

  TheWorld::instance()->destruct();

  // Do nothing including return since this is web.
?>