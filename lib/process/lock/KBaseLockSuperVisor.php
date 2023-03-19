<?php

require_once("lib/BaseClass.php");

abstract class KBaseLockSuperVisor extends BaseClass {

    abstract public function askPreExec();

    abstract public function askPostExec();


}

?>