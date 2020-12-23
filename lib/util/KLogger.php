<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class KLogger extends BaseClass {

    const INFO = "INFO";
    const WARN = "WARN";
    const ERROR = "ERROR";

    protected $stream;

    public function __construct() {
      parent::__construct();

      parent::initialize();
    }

    public function log($level, $rawMessage) {
        $message = date("Y-m-d H:i:s:u") . " " . $level . " " . $rawMessage . "\n";

        $this->stream = fopen($this->getPath(), "a");
        if ($this->stream === FALSE) {
            throw new Exception();
        }
        fwrite($this->stream, $message);

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