<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class BaseErrorHandler {

  public function __construct() {
  }

  public function handleError($exception) {
    printf("RSSErrorHandler::handleError(): message: " . $exception->getMessage() . "\n");
    printf("RSSErrorHandler::handleError(): stack trace: " . $exception->getTraceAsString() . "\n");

    return $this;
  }

}

?>
