<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/filter/DefaultFilter.php");
require_once("lib/util/Util.php");;
require_once("lib/KException.php");

class KORM {
  static protected $tableName;

  static protected $initialized = false;

  static protected $belongTo;
  static protected $belongWith;

  // tableName => array()
  // protected $colNames;
  // protected $propNames;
  static protected $colNames;
  static protected $propNames;
  // colName or propName => type as string
  static protected $types;

  protected $slave;
  protected $master;

  protected $defaultFilter;
  protected $filter;

  protected $container;
  
  public function __construct($tableName) {
    $klassName = get_called_class();

    // parent::__construct();

    $theWorld = TheWorld::instance();
    $this->slave = $theWorld->slave;
    $this->master = $theWorld->master;

    // $this->setPropNames();

    // var_dump($klassName::$propNames);
    if ($klassName::$initialized === false) {
      $klassName::initialize();
      $klassName::$initialized = true;
    }
    // var_dump($klassName::$propNames);

    $this->defaultFilter = new DefaultFilter();
    $this->filter = $this->defaultFilter;

    $this->container = array();

    return $this;
  }

  static public function initialize() {
    $klassName = get_called_class();
     // debug
     // var_dump("bar");
     // end of debug
    if ($klassName::$initialized === true) {
      return;
    }

    // debug
    // var_dump("foo");
    // end of debug

    // $klassName::$initialized = true;
    
    $klassName::$types = array();
    
    $klassName::$belongTo = null;
    $klassName::$belongWith = null;

    $klassName::autoSetColNames();

    $klassName::$initialized = true;
  }

  static public function setTableName($tableName) {
    
        $klassName = get_called_class();
        
        $klassName::$tableName = $tableName;
  }

  static public function getStateInitialized() {
    $klassName = get_called_class();

    return $klassName::$initialized;
  }

  protected function setPropNames() {

  }

  static public function fetchOne($where = null, $orderBy = null) {
    // debug
    // refactor. Implement this part by CoC
    // $tableName = "";
    // end of debug
    // $self = new $klasssName($this->tableName);

    $klassName = get_called_class();

    $object = $klassName::xfetchOne($where, $orderBy);

    // $object->setBelongTo($self->getBelongTo());
    // $object->setBelongWith($self->getBelongWith());
    // debug
    // refactor.
    // $object->setDefaultFilter($self->getDefaultFilter());
    // end of debug
    // $object->setFilter($self->getFilter());

    return $object;
  }

  static public function fetch($where = null, $orderBy = null, $limit = null, $context = null) {
    // debug
    // refactor. Implement this part by CoC
    // $tableName = "";
    // end of debug
    // $klassName = get_class($this);
    $klassName = get_called_class();

    if ($klassName::$initialized !== true) {
      $klassName::initialize();
    }

    // $self = new $klassName($this->tableName);
    
    $objects = $klassName::xfetch($where, $orderBy, $limit, $context);

    foreach($objects as $object) {
      /*
      $object->setBelongTo($klassName::getBelongTo());
      $object->setBelongWith($klassName::getBelongWith());
      */
      // $object->setDefaultFilter($klassName::getDefaultFilter());
      // $object->setFilter($self->getFilter());
    }

    return $objects;
  }

  static public function xfetchOne($where, $orderBy) {
    $klassName = get_called_class();

    return $klassName::fetch($where, $orderBy, 1);
  }

  static public function xfetch($where = null, $orderBy = null, $limit = null, $context = null) {
    $klassName = get_called_class();


    $sql = "SELECT ";
    $i = 1;
    $n = count($klassName::$colNames);

    $sql = $sql . $klassName::makeColNames($klassName::$tableName);;
    if ($klassName::$belongTo != null) {
      $sql = $sql . "," . $klassName::makeColNames($klassName::$belongTo);
    }

    $sql = $sql . " FROM " . $klassName::$tableName;
    if ($klassName::$belongTo != null) {
      $sql = $sql . ", " . $klassName::belongTo;
    }

    if ($where !== null) {
      $sql = $sql . " WHERE ";

      $i = 1;
      $n = count($where);
      foreach($where as $col => $cond) {
        $sql = $sql . $col . " = " . TheWorld::instance()->slave->quote($cond);

        if ($i != $n) {
          $sql = $sql . " AND ";
        }

        ++$i;
      }
    }

    // join
    if ($klassName::$belongTo !== null) {
      if ($where === null) {
        $sql = $sql . " WHERE ";
      }
      $sql = $sql . $tableName . "." . $klassName::$belongWith . " = " . $klassName::$belongTo . "id";
    }


     
    if ($orderBy != null) {
      $sql = $sql . " ORDER BY " . $orderBy;
    }

    if ($limit != null) {
      $sql = $sql . " LIMIT " . $limit;
    }
    
    $statement = TheWorld::instance()->slave->query($sql);

    $result = array();
    // foreach($rows as $row) {
    while($row = $statement->fetch()) {
      // $klassName = $this->getKlassName();
      $klassName = get_called_class();
      $object = new $klassName($klassName::$tableName);
      // $object->autoSetColNames();
      foreach($row as $propName => $val) {
        $object->$propName = $val;
        // if ($context === null) {
          // only for fetchOne
          // $context->$propName = $val;
          // $result = array($context);
        // }
        // else {
          // instead, apply fileter when get prop
          // $object->$propName = $this->filter->apply($val);
        // }
      }
      $result[] = $object;
    }

    return $result;
  }

  public function getCount() {
    $sql = "SELECT count(id) as cnt FROM " . $this->tableName . " LIMIT 1";
    $rows = $this->slave->query($sql);
    $row = $rows[0];

    return $row["cnt"];
  }

  
  // implement __get and __set by this class
  // not by BaseClass (not inherit BaseClass)
  public function __get($propName) {
    $hookMethodName = $this->getHookMethodName($propName);
    if(method_exists($this, $hookMethodName)) {
      return call_user_method_array($hookMethodName, $this, array());
    }

    if (!array_key_exists($propName, $this->container)) {
      return false;
    }

    $val = $this->container[$propName];
    return $this->filter->apply($val);
  }

  public function __set($propName, $val) {
    $hookMethodName = $this->getHookMethodName($propName);
    if(method_exists($this, $hookMethodName)) {
      return 
        call_user_method_array(
          $hookMethodName, 
          $this, 
          array($propName => $val)
        );
    }

    $this->container[$propName] = $val;
    

    return $this;
  }

  protected function getHookMethodName($methodName) {
    $hookMethodName = "hook_" . $methodName;

    return $hookMethodName;
  }

  /*
  public function __call($methodName, $args) {
  }
  */
  

  public function load() {
    if ($this->id === false) {
      throw new Exception("KORM::load(): id is not specified.");
    }
    
    $where = array("id" => $this->id);
    $this->fetch($where, null, null, $this);

    return $this;
  }

  public function getType($colName) {
    $klassName = get_called_class();
    if (!array_key_exists(
      $klassName::$tableName, 
      $klassName::$types
      )) {
      throw new KException("KORM::getType(): type data type does not has tableName: " . $klassName::$tableName . " as key");
    }

    if (!array_key_exists($colName, $klassName::$types[$klassName::$tableName])) {
      throw new KException("KORM::getType(): colName: " . $colName . " does not have type");
    }

    return $klassName::$types[$klassName::$tableName][$colName];
  }

  static public function autoSetColNames() {
    $klassName = get_called_class();
    $klassName::$propNames = array();

    // sub class of KORM defines tableName.
    $sql = "DESCRIBE " . $klassName::$tableName;

    $rows = TheWorld::instance()->slave->query($sql)->fetchAll();

    $klassName::$colNames = array();
    $klassName::$types = array();

    $klassName::$colNames[$klassName::$tableName] = array();
    $klassName::$types[$klassName::$tableName] = array();

    foreach($rows as $row) {
      $field = $row["Field"];
      $type = Util::convertMySQLType($row["Type"]);
      $klassName::$colNames[$klassName::$tableName][] = $field;
      $klassName::$types[$klassName::$tableName][$field] = $type;

      if(
        !is_array($klassName::$propNames[$klassName::$tableName])
        )
      {                 
        $klassName::$propNames[$klassName::$tableName] = 
          array();
      }

      if ($klassName::$belongTo != null) {
        $modifiedField = "pri_" . $field;
        $klassName::$propNames[$klassName::$tableName][$field] = $modifiedField;
      }
      else {
        $klassName::$propNames[$klassName::$tableName][$field] = $field;
      }
      
    }

    if ($klassName::$belongTo == null) {
      return $this;
    }

    if ($klassName::$belongTo != null) {
      $klassName::$colNames[$klassName::$belongTo] = array();
      $sql = "DESCRIBE " . $klassName::$belongTo;
      $rows = TheWorld::instance()->slave->query($sql);
      foreach($rows as $row) {
        $field = $row["Field"];

        $modifiedField = "sec_" . $field;
        $klassName::$colNames[$klassName::$belongTo][] = $field;
        $this->secPropNames[$klassName::$tableName][$field] = $modifiedField;
      }
    }

    return $this;
  }

  public function save() {
    // debug
    // var_dump("container: ");
    // var_dump($this->container);
    // end of debug
    if (array_key_exists("id", $this->container)) {
      $this->saveUpdate();
    }
    else {
      $this->saveNew();
    }
    
    return $this;
  }

  protected function saveUpdate() {
    $klassName = get_called_class();

    if ($klassName::$belongTo !== null) {
      throw new Exception("KORM::saveUpdate(): saveUpdate() cannot be invoked when there is join.");
    }

    // update tablename set foo = bar where id = ?
    $sql = "UPDATE " . $klassName::$tableName . " SET ";
    $i = 1;
    $n = count($klassName::$propNames[$klassName::$tableName]);
    // debug
    // var_dump($klassName::$propNames);
    // end of debug
    foreach($klassName::$propNames[$klassName::$tableName] as $propName) {
      $val = $this->master->quote($this->$propName);
      $sql = $sql . $propName . " = " . $val . " ";
      
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }

    $sql = $sql . " WHERE id = " . $this->id;

    $this->master->query($sql);
  }

  // only invoked when there is no join.
  protected function saveNew() {
    $klassName = get_called_class();

    if ($klassName::$belongTo !== null) {
      throw new Exception("KORM::saveNew(): saveNew() cannot be invoked when there is join.");
    }

    $sql = "INSERT INTO " . $klassName::$tableName . " (";
    $i = 1;
    $n = count($klassName::$propNames);
    foreach($klassName::$propNames as $colName) {
      $sql = $sql . $colName;
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }

    $sql = $sql . ") VALUES(";
    $i = 1;
    $n = count($klassName::$propNames);
    foreach($klassName::$propNames as $propName) {
      $val = $this->propName;
      
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }
    $sql = $sql . ")";
    
    $this->master->query($sql);
  }

  static protected function makeColNames($tableName, $suffix = null) {
    $klassName = get_called_class();

    $sql = "";
    $colNames = $klassName::$colNames[$klassName::$tableName];

    $i = 1;
    $n = count($colNames);
    foreach($colNames as $id => $colName) {
      $sql = $sql . $tableName . "." . $colName . sprintf(" as %s ", $colName);
      
      if ($i != $n) {
        $sql = $sql . ",";
      }
      
      ++$i;
    }

    return $sql;
  }

  protected function getKlassName() {
    return get_class($this);
  }

  public function setBelongTo($belongTo) {
    $klassName = get_called_class();

    $klassName::$belongTo = $belongTo;

    return $this;
  }

  public function getBelongTo() {
    $klassName = get_called_class();

    return $klassName::$belongTo;
  }

  public function setBelongWith($belongWith) {
    $klassName = get_called_class();

    $klassName::$belongWith = $belongWith;

    return $this;
  }

  public function getBelongWith() {
    $klassName = get_called_class();

    return $klassName::$belongWith;
  }

  public function setDefaultFilter($aFilter) {
    $this->defaultFilter = $aFilter;

    return $this;
  }

  public function getDefaultFilter() {
    return $this->defaultFilter;
  }

  public function setFilter($aFilter) {
    $this->filter = $aFilter;

    return $this;
  }

  public function getFilter() {
    return $this->filter;
  }

  static public function getPropNames($tableName = null) {
    $klassName = get_called_class();
    // debug
    if ($tableName === null) {
      return $klassName::$propNames[$klassName::$tableName];
    }
    else {
      return $klassName::$propNames[$tableName];
    }
  }

}

?>