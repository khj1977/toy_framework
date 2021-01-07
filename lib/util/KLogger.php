<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");
require_once("lib/stream/HTMLDebugStream.php");
require_once("lib/stream/KFileStream.php");
require_once("lib/util/KFile.php");

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
      parent::initialize();

      $path = $this->getPath();

      // deubg
      // Is there better way? I think chmod every time is non-sense.
      $file = new KFile();
      $file->setPath($path);
      $this->stream = $file->open("a");
      $file->chmod(0777);
      // end of debug

      return $this;
    }

    public function log($level, $rawMessage) {
      $message = date("Y-m-d H:i:s:u") . " " . $level . " " . $rawMessage . "\n";
        
      $this->stream->puts($message);

      // debug
      // really, all kind is ordinary?
      // use level?
      $this->htmlStream->log(HTMLDebugStream::KIND_ORDINARY, $message);
      // end of debug

      return $this;
    }

    public function close() {
      $this->stream->close();

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