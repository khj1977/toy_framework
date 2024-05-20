<?php

set_include_path(get_include_path() . "" . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../"));

require_once("lib/BaseBatch.php");
require_once("lib/TheWorld.php");

class TFWRestPipeBatch extends BaseBatch {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function xmain($args) {
    // debug
    // implement this method.
    // end of debug
  }

}

if (count($argv) != 2) {
  Util::println("usage: cat foo.csv | tfw.sh TFWRestPipe http://xxx.yyy/cmd.php | sort > bar.csv");
  exit(-1);
}

$obj = new TFWRestPipeBatch();
try {
  $obj->run($argv);
}
catch(Exception $e) {
}

return 1;

?>