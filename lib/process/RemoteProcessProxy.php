<?php

require_once("lib/process/BaseProcess.php");
require_once("lib/KException.php");

// Exec actual process at remote server.
// Therefore, this class is proxy of that actual
// process.
class RemoetProcessProxy extends BaseProcess {

  public function __construct() {
    return $this;
  }

  public function exec() {
    // debug
    // not implemented yet.
    throw new KException("RemoteProcessProxy::exec(): this method has not been implemented yet.");
    // end of debug
  }

}

?>