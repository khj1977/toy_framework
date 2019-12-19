<?php

require_once("lib/input_stream/ABSInputStream.php");
require_once("lib/KException.php");

class CSVInputStream extends ABSInputStream {

  protected $path;
  protected $stream;
  protected $line;

  public function __construct() {
    parent::__construct();

    $this->path = null;
    $this->stream = null;
    $this->line = null;
 
    return $this;
  }

  public function open($path) {
    $this->path = $path;

    $this->stream = fopen($path, "r");
    if ($this->stream === false) {
      throw new KException("CSVInputStream::open(): file cannot be opened: " . $this->path);
    }

    return $this;
  }

  public function next() {
    $this->line = trim(fgets($this->stream));
    if (!$this->line) {
      return $this;
    }

    return $this;
  }

  public function getItem() {
    return explode(",", $line);
  }

}

?>