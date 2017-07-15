<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class BasicErrorHandler {

  // class UStdStream
  protected $stderr;
  // class UTextStream
  protected $outputFile;

  public function __construct($outputPath) {
    // construct $stdout.
    // construct $outputFile.
  }

  // destructor is not used since we want to control closing 
  // stream not depends on system GC
  public function closeStreams() {
  }

  // param: $ex: the base class of $ex is UException
  public function handleException($ex) {
    $stderr->write($ex->getMessage());
    $outputFile->write($ex->getMessage());
  }

}

?>
