<?php

require_once("lib/BaseClass.php");

class WebArguments extends BaseClass {

  protected $get;
  protected $post;
  protected $merged;
  protected $i_indexMerged;

  public function __construct() {
    $this->get = $_GET;
    $this->post = $_POST;
    $this->merged = array_merge($_POST, $_GET);
   
    $this->i_indexMerged = array();

    $i = 0;
    foreach($this->merged as $key => $val) {
      $this->i_indexMerged[$i] = array($key => $val);

      ++$i;
    }

    return $this;
  }

  /*
  public function getArguments() {}
    return $this->merged;
  }
  */

  public function get($key) {
    return $this->merged[$key];
  }

  public function getPost($Key) {
    // return $_POST;
    return $this->post($key);
  }

  public function getGet($key) {
    return $this->get[$key];
  }

}

?>