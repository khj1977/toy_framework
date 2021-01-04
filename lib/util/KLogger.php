<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");
require_once("lib/stream/HTMLDebugStream.php");

class KLogger extends BaseClass {

    const INFO = "INFO";
    const WARN = "WARN";
    const ERROR = "ERROR";

    protected $stream;
    protected $htmlStream;

    public function __construct($htmlStream) {
      parent::__construct();

      $this->htmlStream = $htmlStream;

      parent::initialize();
    }

    protected function initialize() {
      // parent::initialize();

      $path = $this->getPath();
      $this->stream = fopen($path, "a");
      if ($this->stream === false) {
        throw new Exception("KLogger::initialize(): file cannot be opened: " . $path);
      }

      return $this;
    }

    public function log($level, $rawMessage) {
      $message = date("Y-m-d H:i:s:u") . " " . $level . " " . $rawMessage . "\n";
        
      if ($this->stream === FALSE) {
          throw new Exception();
      }
      fwrite($this->stream, $message);

      $this->htmlStream->log(HTMLDebugStream::KIND_ORDINARY, $message);

      return $this;
    }

    public function close() {
      fclose($this->stream);

      return $this;
    }

    protected function getPath() {
      $baseDir = TheWorld::instance()->getBaseDir();

      $logDir = $baseDir . "/log";

      $logFileName = "log-" . date("Y-m-d") . ".log";

      $logFilePath = $logDir . "/" . $logFileName;

      return $logFilePath;
    }

}

?>