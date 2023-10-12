<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

abstract class BaseFacade extends BaseClass {
  // Type 1 facade express process chain for simple situation
  // proess1 => proecss2 => process3 ... => process_n
  // make custom facade for each situation.

  // Type 2 facade can express graph of process.

  abstract public function exec($f);

}

?>