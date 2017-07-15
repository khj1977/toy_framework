<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseErrorHandler.php");

class RSSErrorHandler extends BaseErrorHandler {

  public function __construct() {
  }

  public function handleError($exception) {
    // debug
    // implement this method.
    // end of debug

    printf("RSSErrorHandler::handleError(): message: " . $exception->getMessage() . "\n");
    printf("RSSErrorHandler::handleError(): stack trace: " . $exception->getTraceAsString() . "\n");
  }

}

?>
