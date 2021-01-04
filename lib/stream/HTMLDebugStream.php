<?php

require_once("lib/BaseClass.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");
require_once("lib/util/Util.php");

class HTMLDebugStream extends BaseClass {

  const KIND_ORDINARY = "ORDINARY";
  const KIND_SQL = "SQL";

  // buffer to retain content of log
  protected $buffers;
  protected $stage;

  public function __construct($stage) {
    parent::__construct();

    $this->stage = $stage;

    return $this;
  }

  protected function initialize() {
    $this->buffers->set(HTMLDebugStream::KIND_ORDINARY, new KArray());
    $this->buffers->set(HTMLDebugStream::KIND_SQL, new KArray());

    return $this;
  }

  public function log($kind, $rawMessage) {
    if ($this->buffers->check($kind) === false){
      throw new Exception("HTMLDebugStream::log::there is kind: " . $kind);
    }
    $this->buffers->get($kind)->push($rawMessage);

    return $this;
  }

  public function varDump($kind, $obj) {
    if ($this->buffers->check($kind) === false){
      throw new Exception("HTMLDebugStream::log::there is kind: " . $kind);
    }
    $this->buffers->get($kind)->push(var_export($obj, true));

    return $this;
  }

  public function render() {
    // Only dev stage, debug log is displayed on web browser.
    if ($this->stage != "Dev") {
      return $this;
    }
    // <div class="alert alert-primary" role="alert">
    // A simple primary alert—check it out!
    // </div>
    foreach($this->buffers as $kind => $buffer) {
      foreach($buffer as $rawMessage) {
        $element = sprintf('<div class="alert alert-primary" role="alert">%s</div>', Util::htmlspecialchars($rawMessage));

        print($element);
      }
    }

    return $this;
  }

}

?>