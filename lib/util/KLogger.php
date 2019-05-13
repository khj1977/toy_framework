<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

class KLogger extends BaseClass {

    const INFO = "INFO";
    const WARN = "WARN";
    const ERROR = "ERROR";

    public function __construct() {
      parent::__construct();

      parent::initialize();
    }

    public function log($level, $rawMessage) {
        $message = date("Y-m-d H:i:s:u") . " " . $level . " " . $rawMessage . "\n";

        $stream = fopen($this->getPath(), "a");
        if ($stream === FALSE) {
            throw new Exception();
        }
        fwrite($stream, $message);
        fclose($stream);
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