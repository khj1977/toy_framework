<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

// Table => cols (assign names) => DBRawCol and DBRawCols as collection
abstract class BaseTable extends BaseClass {

  protected $tableName;
  protected $slave;

  public function __construct($tableName) {
    $this->tableName = $tableName;

    $this->slave = TheWorld::instance()->getSlave();

    return $this;
  }

  abstract protected function getRawColNames();

}

?>