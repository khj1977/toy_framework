<?php

require_once("lib/process/BaseFacade.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class ChainProcessFacade extends BaseFacade {

  protected $processes;

  public function __consturct() {
    parent::__construct();

    $this->processes = new KArray();

    return $this;
  }

  // no remove or pop method because no usage cannot be found at this time.
  public function pushProcess($process) {
    $this->processes->push($process);
  }

  public function exec($f) {
    $this->processes->each(function($process) {
      $process->exec();
    });
  
    return $this;
  }

  public function traverseByVisitor($visitor) {
    $this->processes->each(function($process) use ($visitor) {
      $visitor->exec($process, new KHash());
    });
  }

}

?>