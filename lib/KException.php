<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/util/KLogger.php");
require_once("lib/TheWorld.php");

class KException extends Exception {

  public function __construct($message) {
    parent::__construct($message);
    $this->doLogging($message);
    // debug
    // do debugStream->varDump() ?
    // end of debug

    return $this;
  }

  protected function doLogging($message) {
    $message = "KException::doLogging(): " . $message;

    $logger = TheWorld::instance()->logger;
    $logger->log(KLogger::ERROR, $message);
  }

}

?>
