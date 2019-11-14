<?php

require_once("lib/process/BaseFacade.php");

class ChainProcessFacade extends BaseFacade {

  protected $processes;

  public function __consturct() {
    parent::__construct();

    $this->processes = array();

    return $this;
  }

  // no remove or pop method because no usage cannot be found at this time.
  public function pushProcess($process) {
    $this->processes[] = $process;
  }

  public function exec() {
    foreach($this->processes as $process) {
      $proess->exec();
    }

    return $this;
  }

}

?>