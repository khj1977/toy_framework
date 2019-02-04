<?php

require_once("lib/KORM.php");
require_once("Util.php");

class BaseKORMModel extends KORM {

  public function __construct() {
    $klassName = $this->getKlassName();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($klassName), "_model");

    // initialize parent later than above table related settings.
    parent::__construct($tableName);
  }

}

?>