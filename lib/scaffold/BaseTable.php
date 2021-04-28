<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/TheWorld.php");

// Table => cols (assign names) => DBRawCol and DBRawCols as collection
abstract class BaseTable extends BaseClass {

  protected $tableName;
  protected $slave;
  protected $orm;

  public function __construct($tableName) {
    parent::__construct();
    parent::initialize();

    $this->tableName = $tableName;

    $this->slave = TheWorld::instance()->slave;
    
    $this->orm = null;

    // var_dump($this->slave);

    return $this;
  }

  public function getORM() {
    return $this->orm;
  }

  abstract protected function getRawColNames();

}

?>