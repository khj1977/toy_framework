<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

class KFileStream extends BaseClass {

  protected $internalStream;
  protected $path;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  public function open($path, $mode) {
    $this->path = $path;
    $this->internalStream = fopen($this->path, $mode);
    if ($this->internalStream === false) {
      throw new Exception("FileStream::open(): file cannot be opened: " . $path);
    }

    return $this;
  }

  public function close() {
    fclose($this->internalStream);

    return $this;
  }

  public function puts($data) {
    fwrite($this->internalStream, $data);

    return $this;
  }

}

?>