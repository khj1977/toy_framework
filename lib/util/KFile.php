<?php

  require_once("lib/BaseClass.php");
  require_once("lib/stream/KFileStream.php");

  class KFile extends BaseClass {

    protected $path;

    public function __construct() {
      parent::__construct();

      return $this;
    }

    public function setPath($path) {
      $this->path = $path;

      return $this;
    }

    public function open($mode) {
      $stream = new KFileStream();
      $stream->open($this->path, $mode);

      return $stream;
    }

    public function isExist() {
      return file_exists($this->path);
    }

    public function create() {
      $err = touch($this->path);
      if ($err === false) {
        throw new Exception("KFile::create(): file cannot be created: " . $this->path);
      }

      return $this;
    }

    public function chmod($mode) {
      $err = chmod($this->path, $mode);
      if ($err === false) {
        throw new Exception("KFile::chomd(): chmod cannot be done: " . $mode);
      }

      return $this;
    }

  }

?>