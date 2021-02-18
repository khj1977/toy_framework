<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KORM.php");
require_once("lib/util/Util.php");

class BaseKORMModel extends KORM {

  static public function initialize() {
    // $klassName = $this->getKlassName();
    $klassName = get_called_class();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($klassName), "_model");
    
    // initialize parent later than above table related settings.
    // parent::__construct($tableName);
    parent::initialize();
    $klassName::setTableName($tableName);

    if ($klassName::$initialized === true) {
      return;
    }

    // debug
    parent::initialize();
    // end of debug
  }

  /*
  static public function getTableName() {
    $klassName = get_called_class();

    return $klassName::$tableName;
  }
  */

}

?>