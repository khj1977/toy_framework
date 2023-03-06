<?php

require_once("lib/process/BaseProcess.php");
require_once("lib/KException.php");
require_once("lib/RESTApi.php");
require_once("lib/data_struct/KHash.php");

// Exec actual process at remote server.
// Therefore, this class is proxy of that actual
// process.
class RemoetProcessProxy extends BaseProcess {
  protected $func;

  public function __construct() {
    return $this;
  }

  protected function preExec() {

    return $this;
  }

  public function setInternalFunction($f) {
    $this->func = $f;
  }

  protected function xexec() {
    $f = $this->func;

    $klassName = $this->getKlassName();
    $url = $this->makeUrl($klassName);
    $api = new RESTApi();
    $arg = new KHash();
    $arg->set("func", $f);
    try {
      $api->setBaseUrl($url)->call($arg);
    }
    catch(KException $ex) {
      $msg = "RemoteProcessProxy::xexec(): " . $ex->getMessage();

      $theWorld = TheWorld::instance();
      $theWorld->logger->log(KLogger::WARN, $msg);

      throw new KException($msg);
    }

    return $this;
  }
  protected function postExec() {

    return $this;
  }

}

?>