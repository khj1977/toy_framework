<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");
require_once("lib/filter/DefaultFilter.php");
require_once("lib/util/Util.php");;
require_once("lib/KException.php");
require_once("lib/data_struct/KHash.php");
require_once("lib/data_struct/KArray.php");

class KORM {
  static protected $superInitialized = false;

  static protected $initialized;
  static protected $tableName;

  static protected $belongTo;
  static protected $belongWith;
  static protected $belongToTableName;

  /*
  static protected $tableName;
  static protected $initialized = false;

  static protected $belongTo = null;
  static protected $belongWith = null;
  static protected $belongToTableName = null;
*/

  // tableName => array()
  // protected $colNames;
  // protected $propNames;
  static protected $colNames;
  static protected $propNames;
  static protected $secPropNames;
  // colName or propName => type as string
  static protected $types;

  protected $slave;
  protected $master;

  // null filter. return the same val as ORM have.
  protected $defaultFilter;
  protected $filter;

  protected $container;

  public function __construct() {
    $klassName = get_called_class();

    // static::setTableName($tableName);

    // parent::__construct();

    $theWorld = TheWorld::instance();
    $this->slave = $theWorld->slave;
    $this->master = $theWorld->master;

    // $this->setPropNames();

    // var_dump(static::$propNames);
    if (static::$initialized === false) {
      static::initialize();
      static::$initialized = true;
    }
    // var_dump(static::$propNames);

    $this->defaultFilter = new DefaultFilter();
    $this->filter = $this->defaultFilter;

    $this->container = array();

    return $this;
  }

  static public function initialize() {
    $klassName = get_called_class();

    if (static::$superInitialized === false) {
      static::$initialized = new KHash();
      static::$tableName = new KHash();;
    
      static::$belongTo = new KHash();
      static::$belongWith = new KHash();
      static::$belongToTableName = new KHash();

      static::$colNames = new KHash();
      static::$propNames = new KHash();
      static::$secPropNames = new KHash();
      static::$types = new KHash();
    }

    $klassName = get_called_class();
    if (static::$initialized->get($klassName) !== false) {
      return true;
    }
    else {
      static::$initialized->set($klassName, true);

      static::$tableName->set($klassName, null);
      static::$belongTo->set($klassName, null);
      static::$belongWith->set($klassName, null);
      static::$belongToTableName->set($klassName, null);

      static::$colNames->set($klassName, null);
      static::$propNames->set($klassName, null);
      static::$secPropNames->set($klassName, null);

      static::$types->set($klassName, null);
    }

    static::$types->set($klassName, array());

    static::autoSetColNames($klassName, static::$tableName);

    static::$superInitialized = true;

    return true;
  }

  static public function setTableName($tableName) {
    
        $klassName = get_called_class();
        
        static::$tableName->set($klassName, $tableName);
  }

  static public function getTableName() {
    $klassName = get_called_class();

    return static::$tableName->get($klassName);
  }

  static public function getStateInitialized() {
    $klassName = get_called_class();

    return static::$initialized->get($klassName);
  }

  protected function setPropNames() {

  }

  static public function fetchOne($where = null, $orderBy = null) {
    $klassName = get_called_class();

    $objects = static::xfetchOne($where, $orderBy);

    return $objects[0];
  }

  static public function fetch($where = null, $orderBy = null, $limit = null, $context = null) {
    $klassName = get_called_class();

    if (static::$initialized->get($klassName) !== true) {
      static::initialize();
    }
    
    $objects = static::xfetch($where, $orderBy, $limit, $context);

    foreach($objects as $object) {
      $object->setDefaultFilter(new DefaultFilter());
      $object->setFilter($object->getFilter());
    }

    return $objects;
  }

  static public function xfetchOne($where, $orderBy) {
    $klassName = get_called_class();

    return static::fetch($where, $orderBy, 1);
  }

  static public function xfetch($where = null, $orderBy = null, $limit = null, $context = null) {
    $klassName = get_called_class();


    $sql = "SELECT ";
    $i = 1;
    $n = count(static::$colNames);

    $sql = $sql . static::makeColNames(static::$tableName);

    if (static::$belongTo->get($klassName) != null) {
      $belongTo = static::$belongTo->get($klassName);
      $sql = $sql . "," . $belongTo::makeColNames(static::$belongToTableName);
      $foo = $belongTo::makeColNames(static::$belongToTableName);
    }

    $sql = $sql . " FROM " . static::$tableName;
    if (static::$belongToTableName->get($klassName) != null) {
      $sql = $sql . ", " . static::$belongToTableName->get($klassName);
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
    if (static::$belongTo->get($klassName) !== null) {
      if ($where === null) {
        $sql = $sql . " WHERE ";
      }
      $belongWith = static::$belongWith->get($klassName);
      $fromKey = $belongWith["from_key"];
      $toKey = $belongWith["to_key"];
      $sql = $sql . static::$tableName->get($klassName) . "." . $fromKey . " = " .static::$belongToTableName->get($klassName) . "." . $toKey;
    }


     
    if ($orderBy != null) {
      $sql = $sql . " ORDER BY " . $orderBy;
    }

    if ($limit != null) {
      $sql = $sql . " LIMIT " . $limit;
    }
    
    $statement = TheWorld::instance()->slave->query($sql);
    $result = array();
    $klassName = get_called_class();

    if (static::$belongTo->get($klassName) != null) {
      $joinedTableName = Util::omitSuffix(Util::upperCamelToLowerCase(static::$belongTo->get($klassName)), "_model");
      $joinedPropPattern = sprintf("/%s/", $joinedTableName);
    }
    // foreach($rows as $row) {
    while($row = $statement->fetch()) {
      // $klassName = $this->getKlassName();
      // filter is assigned to object.
      // in that time, filter is assigned object by object;i.e. by instance val not class val.
      $joinedObject = null;
      $object = new $klassName(static::$tableName);
      if (static::$belongTo->get($klassName) != null) {
        // Do join recursively?
        $joinedObject = new $belongTo($joinedTableName);
      }
      foreach($row as $propName => $val) {
        if (static::$belongTo->get($klassName) != null) {
          
          $joined = false;
          if (preg_match($joinedPropPattern, $propName) == 1) {
            $joined = true;
          }

          $splitted = explode("_", $propName);
          $propName = $splitted[1];
          if ($joined === true) {
            $joinedObject->$propName = $val;
          }
          else {
            $object->propName = $val;
          }
        }
        else {
          $object->$propName = $val;
        }
        // do not modify a prop but apply filter when __get() is called.
        // $object->$propName = $this->filter->apply($val);
      }
      if ($joinedObject != null) {
        $object->joined = $joinedObject;
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
    $hookMethodName = $this->getGetterHookMethodName($propName);
    if(method_exists($this, $hookMethodName)) {
      // debug
      // replace by call_user_func_array
      // call_user_func_array(array($this->impl, $methodName), $args);
      // From php.net
      // $foo = new foo;
      // call_user_func_array(array($foo, "bar"), array("three", "four"));
      // return call_user_method_array($hookMethodName, $this, array());
      return call_user_func_array(array($this, $hookMethodName), array());
      // end of debug
    }

    if (!array_key_exists($propName, $this->container)) {
      return false;
    }

    $val = $this->container[$propName];
    return $this->filter->apply($val);
  }

  public function __set($propName, $val) {
    $hookMethodName = $this->getSetterHookMethodName($propName);
    if(method_exists($this, $hookMethodName)) {
      // debug
      // replace the following obsolete function
      /*
      return 
        call_user_method_array(
          $hookMethodName, 
          $this, 
          array($propName => $val)
        );
      */
      return call_user_func_array(array($this, $hookMethodName), array($propName => $val));
      // end of debug
    }

    $this->container[$propName] = $val;
    

    return $this;
  }

  protected function getGetterHookMethodName($methodName) {
    $hookMethodName = "hook_getter_" . $methodName;

    return $hookMethodName;
  }

  protected function getSetterHookMethodName($methodName) {
    $hookMethodName = "hook_setter_" . $methodName;

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
    if (
      static::$types->get($klassName)->check(static::$tableName)->get(static::$tableName)) {
      throw new KException("KORM::getType(): type data type does not has tableName: " . static::$tableName . " as key");
    }

    if (!static::$types->get($klassName)->check(static::$tableName->get($klassName))) {
      throw new KException("KORM::getType(): colName: " . $colName . " does not have type");
    }

    return static::$types->get($klassName)->get(static::$tableName)->get($colName);
  }

  static public function autoSetColNames($klassName, $tableName) {
    // $klassName = get_called_class();
    static::$propNames->set($klassName, new KHash());

    // sub class of KORM defines tableName.
    // $sql = "DESCRIBE " . static::$tableName;
    $sql = "DESCRIBE " . $tableName;

    $rows = TheWorld::instance()->slave->query($sql)->fetchAll();

    static::$colNames->set($klassName, new KHash());
    static::$types->set($klassName, new KHash());

    static::$colNames->get($klassName)->set(static::$tableName, new KArray());
    static::$types->get($klassName)->set(static::$tableName, new KHash());

    foreach($rows as $row) {
      $field = $row["Field"];
      $type = Util::convertMySQLType($row["Type"]);

      if(
        // !is_array(static::$propNames[static::$tableName])
        !static::$propNames->get($klassName)->check(static::$tableName)
        )
      {                 
        !static::$propNames->get($klassName)->set(static::$tableName, new KHash())
      }

      if (static::$belongToTableName != null) {
        $modifiedField = "pri_" . $field;
        static::$propNames->get($klassName)->get(static::$tableName)->set($field, $modifiedField);
        static::$colNames->get($klassName)->set[static::$tableName, $field);
        static::$types->get($klassName)->get(static::$tableName)->set($field, $type);
      }
      else {
        static::$propNames->get($klassName)->get(static::$tableName)->set($field, $field);
        static::$colNames->get($klassName)->get(static::$tableName)->push($field);
        static::$types->get($klassName)->get(static::$tableName)->set($field, $type);
      }
      
    }
    
    if (static::getTableName() != null) {
      static::$colNames->get($klassName)->set(static::$belongToTableName->get($klassName), new KArray());
      // refactor
      static::$secPropNames->get($klassName) = new KHash();
      static::$secPropNames->get($klassName)->set(static::$belongToTableName, array());
      $sql = "DESCRIBE " . static::$belongToTableName;
      $srows = TheWorld::instance()->slave->query($sql)->fetchAll();
      // var_dump($srows);
      foreach($srows as $srow) {
        $sfield = $srow["Field"];
        $smodifiedField = "sec_" . $sfield;
        $stype = Util::convertMySQLType($srow["Type"]);
        static::$propNames->get($klassName)->get(static::$belongToTableName)->set($sfield, $smodifiedField);
        static::$colNames->get($klassName)->get(static::$belongToTableName)->push($sfield);
        static::$types->get($klassName)->get(static::$belongToTableName)->set($field, $stype);
        
      }
    }

    // debug
    // return $this;
    return;
    // end of debug
  }

  public function save() {
    if (array_key_exists("id", $this->container)) {
      if (Util::isEmpty($this->container["id"])) {
        $this->saveNew();

        return $this;
      }
    }

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

    if (static::$belongTo->get($klassName) !== null) {
      throw new Exception("KORM::saveUpdate(): saveUpdate() cannot be invoked when there is join.");
    }

    // update tablename set foo = bar where id = ?
    $sql = "UPDATE " . static::$tableName->get($klassName) . " SET ";
    $i = 1;
    $n = count(static::$propNames[static::$tableName]);

    foreach(static::$propNames->get($klassName)->get(static::$tableName->get($klassName))->generator() as $propName) {
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

    if (static::$belongTo->get($klassName) !== null) {
      throw new Exception("KORM::saveNew(): saveNew() cannot be invoked when there is join.");
    }

    $sql = "INSERT INTO " . static::$tableName . " (";
    $i = 1;
    $n = count(static::$propNames->get($klassName)->get(static::$tableName);
    foreach(static::$propNames->get(static::$tableName)->generator() as $colName) {
      if (Util::isEmpty($this->$colName)) {
        ++$i;
        continue;
      }

      $sql = $sql . $colName;
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }

    $sql = $sql . ") VALUES(";
    $i = 1;
    $n = count(static::$propNames->get($klassName)->get(static::$tableName->get($klassName)));

    foreach(static::$propNames->get($klassName)->get(static::$tableName)->generator() as $propName) {
      $val = $this->$propName;

      if (Util::isEmpty($val)) {
        ++$i;
        continue;
      }

      $sql = $sql . TheWorld::instance()->master->quote($val);
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
    // $colNames = static::$colNames[static::$tableName];
    $colNames = static::$colNames->get($klassName)->get($tableName);

    $i = 1;
    $n = count($colNames);
    foreach($colNames as $id => $colName) {
      if (static::$belongToTableName->get($klassName) == null) {
        $sql = $sql . $tableName . "." . $colName . sprintf(" as %s", $colName);
      }
      else {
        if (strcmp($tableName, static::$belongToTableName->get($klassName)) == 0) {
          $sql = $sql . $tableName . "." . $colName . sprintf(" as %s_%s ", static::$belongToTableName->get($klassName), $colName);
        }
        else {
          $sql = $sql . $tableName . "." . $colName . sprintf(" as %s_%s ", $tableName, $colName);
        }
    }
      
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

  static public function setBelongTo($belongTo) {
    $klassName = get_called_class();

    static::$belongTo->set($klassName, $belongTo);

    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($belongTo), "_model");
    static::$belongToTableName->set($klassName, $tableName);

    // debug
    // $belongTo::autoSetColNames($belongTo, static::$belongToTableName);
    // end of debug

    return true;
  }

  static public function getBelongTo() {
    $klassName = get_called_class();

    return static::$belongTo->get($klassName);
  }

  // The format of belongWith is as follows:
  // array("from_field" => "id", "to_field" => customer_id)
  // from is key of this class. to is target of join.
  static public function setBelongWith($belongWith) {
    $klassName = get_called_class();

    static::$belongWith->set($klassName, $belongWith);

    return true;
  }

  public function getBelongWith() {
    $klassName = get_called_class();

    return static::$belongWith->get($klassName);
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
      return static::$propNames->get($klassName)->get(static::$tableName);
    }
    else {
      return static::$propNames->get($klassName)->get($tableName);
    }
  }

}

?>