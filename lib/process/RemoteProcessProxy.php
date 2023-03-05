<?php

require_once("lib/process/BaseProcess.php");
require_once("lib/KException.php");
require_once("lib/RESTApi.php");
require_once("lib/data_struct/KHash.php");

// Exec actual process at remote server.
// Therefore, this class is proxy of that actual
// process.
class RemoetProcessProxy extends BaseProcess {

  public function __construct() {
    return $this;
  }

  protected function preExec() {

    return $this;
  }

  protected function xexec() {
    $klassName = $this->getKlassName();
    $url = $this->makeUrl($klassName);
    $api = new RESTApi();
    $api->setBaseUrl($url)->call(new KHash());
  }
  protected function postExec() {

    return $this;
  }

}

?>