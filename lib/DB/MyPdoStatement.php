<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegatable.php");

class MyPdoStatement extends BaseDelegatable {

  protected $statement;

  public function __construct($statement) {
    $this->statement = $statement;
    $this->setImpl($statement);

    return $this;
  }

  public function fetch($mode = null) {
    if ($mode == null) {
      $raw = $this->statement->fetch();
    }
    else {
      $raw = $this->statement->fetch($mode);
    }

    // omit int => foo but hash.
    if (!is_array($raw)) {
      return false;
    }

    $result = $this->onlyHash($raw);

    return $result;
  }

  public function fetchAll($mode = null) {
    if ($mode == null) {
      $raws = $this->statement->fetchAll();
    }
    else {
      $raws = $this->statement->fetchAll($mode);
    }

    // omit int => foo but hash.
    if (!is_array($raws)) {
      return false;
    }

    $result = array();
    foreach($raws as $raw) {
      $result[] = $this->onlyHash($raw);
    }

    return $result;
  }

  protected function onlyHash($raw) {
    $result = array();

    foreach($raw as $key => $col) {
      if (preg_match("/^[a-zA-Z_]*$/", $key) != 1) {
        continue;
      }

      $result[$key] = $col;
    }

    return $result;
  }

}

?>