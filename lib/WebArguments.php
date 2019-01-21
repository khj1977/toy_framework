<?php

require_once("lib/BaseClass.php");
require_once("lib/KException.php");

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
    /*
    if (!array_key_exists($key, $this->merged)) {
      throw new KException("WebArguments::get(): val is not exist with key: " . $key);
    }
    */

    return $this->merged[$key];
  }

  public function getPost($Key) {
    /*
    if (!array_key_exists($key, $this->post)) {
      throw new KException("WebArguments::get(): val is not exist with key: " . $key);
    }
    */
    // return $_POST;
    return $this->post[$key];
  }

  public function getGet($key) {
    /*
    if (!array_key_exists($key, $this->get)) {
      throw new KException("WebArguments::get(): val is not exist with key: " . $key);
    }
    */

    return $this->get[$key];
  }

  public function getPostData() {
    return $this->post;
  }

}

?>