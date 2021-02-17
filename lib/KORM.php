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
    if (static::$initialized->get($klassName) === false) {
      static::initialize();
      static::$initialized->set($klassName, true);
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

      static::$tableName = new KHash();
      static::$belongTo = new KHash();
      static::$belongWith = new KHash();
      static::$belongToTableName = new KHash();
      static::$colNames = new KHash();
      static::$propNames = new KHash();
      static::$secPropNames = new KHash();
      static::$types = new KHash();

      static::$superInitialized = true;
    }

    if (static::$initialized->get($klassName) !== false) {
      return true;
    }
    else {
      static::$tableName->set($klassName, new kHash());

      static::$belongTo->set($klassName, new kHash());
      static::$belongWith->set($klassName, new kHash());
      static::$belongToTableName->set($klassName, new kHash());
      static::$colNames->set($klassName, new kHash());
      static::$propNames->set($klassName, new kHash());
      static::$secPropNames->set($klassName, new kHash());
      static::$types->set($klassName, new kHash());

      static::$types->set($klassName, new KHash());

      static::$initialized->set($klassName, true);
    }
      
      // static::$tableName->get($klassName)->set($klassName, new KHash());

      // static::$belongTo->get($klassName)->set($klassName, new KHash());
      // static::$belongWith->get($klassName)->set($klassName, new KHash());
      // static::$belongToTableName->get($klassName)->set($klassName, new KHash());

      // static::$colNames->get($klassName)->set($klassName, null);
      // static::$propNames->get($klassName)->set($klassName, null);
      // static::$secPropNames->get($klassName)->set($klassName, null);

      // static::$types->get($klassName)->set($klassName, null);

      

    // debug
    // Is the following required?
    
    // end of debug

    // static::autoSetColNames($klassName, static::$tableName->get($klassName));

    return true;
  }

  static public function setTableName($tableName) {
        $klassName = get_called_class();
        
        static::$tableName->get($klassName)->set($klassName, $tableName);

        static::autoSetColNames($klassName, static::$tableName->get($klassName)->get($klassName));
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

    // return $objects[0];
    return $objects->get(0);
  }

  static public function fetch($where = null, $orderBy = null, $limit = null, $context = null) {
    $klassName = get_called_class();

    // if (static::$initialized->get($klassName) !== true) {
    if (static::$superInitialized !== true) {
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
    $tableName = static::$tableName->get($klassName)->get($klassName);
    $belongToTableName = static::$belongToTableName->get($klassName)->get($klassName);

    $sql = "SELECT ";
    $i = 1;
    $n = static::$colNames->get($klassName)->len();

    $sql = $sql . static::makeColNames($tableName);

    if ($belongToTableName != null) {
      $belongTo = static::$belongTo->get($klassName)->get($klassName);
      $sql = $sql . "," . $belongTo::makeColNames($belongToTableName, $tableName);
    }

    $sql = $sql . " FROM " . $tableName;
    if ($belongToTableName != null) {
      $sql = $sql . ", " . $belongToTableName;
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
    if ($belongToTableName !== false) {
      if ($where === null) {
        $sql = $sql . " WHERE ";
      }
      $belongWith = static::$belongWith->get($klassName);
      $fromKey = $belongWith["from_key"];
      $toKey = $belongWith["to_key"];
      $sql = $sql . static::$tableName->get($klassName)->get($klassName) . "." . $fromKey . " = " . $belongToTableName . "." . $toKey;
    }


     
    if ($orderBy != null) {
      $sql = $sql . " ORDER BY " . $orderBy;
    }

    if ($limit != null) {
      $sql = $sql . " LIMIT " . $limit;
    }
    
    $statement = TheWorld::instance()->slave->query($sql);
    // $result = array();
    $result = new KArray();
    $klassName = get_called_class();

    if (static::$belongTo->get($klassName)->get($klassName) != null) {
      $joinedTableName = Util::omitSuffix(Util::upperCamelToLowerCase(static::$belongTo->get($klassName)->get($klassName)), "_model");
      $joinedPropPattern = sprintf("/%s/", $joinedTableName);
    }
    // foreach($rows as $row) {
    while($row = $statement->fetch()) {
      // $klassName = $this->getKlassName();
      // filter is assigned to object.
      // in that time, filter is assigned object by object;i.e. by instance val not class val.
      $joinedObject = null;
      $object = new $klassName($tableName);
      if (static::$belongTo->get($klassName)->get($klassName) != null) {
        // Do join recursively?
        $joinedObject = new $belongTo($joinedTableName);
      }
      foreach($row as $propName => $val) {
        if (static::$belongTo->get($klassName)->get($klassName) != null) {
          
          $joined = false;
          if (preg_match($joinedPropPattern, $propName) == 1) {
            $joined = true;
          }

          $splitted = explode("_", $propName);
          if ($joined === true) {
            $propName = $splitted[1];
            $joinedObject->$propName = $val;
          }
          else {
            $object->$propName = $val;
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

      $result->push($object);
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
    $tableName = static::$tableName->get($klassName)->get($klassName);


    if (
      // static::$types->get($klassName)->check(static::$tableName)->get(static::$tableName)) {
      // static::$types->get($klassName)->get($tableName)->set($field, $type);
        !static::$types->get($klassName)->check($tableName)) {
      throw new KException("KORM::getType(): type data type does not has tableName: " . static::$tableName . " as key");
    }

    if (!static::$types->get($klassName)->check($tableName)) {
      throw new KException("KORM::getType(): colName: " . $colName . " does not have type");
    }

    return static::$types->get($klassName)->get($tableName)->get($colName);
  }

  static public function autoSetColNames($klassName, $tableName) {
    // $tableName = static::$tableName->get($klassName)->get($klassName);
    // $belongToTableName = static::$belongToTableName->get($klassName)->get($klassName);
    // $klassName = get_called_class();
    $klassName::$propNames->set($klassName, new KHash());

    // sub class of KORM defines tableName.
    // $sql = "DESCRIBE " . static::$tableName;
    $sql = "DESCRIBE " . $tableName;

    $rows = TheWorld::instance()->slave->query($sql)->fetchAll();

    // static::$colNames->set($klassName, new KHash());
    // static::$types->set($klassName, new KHash());

    $klassName::$colNames->get($klassName)->set($tableName, new KArray());
    $klassName::$types->get($klassName)->set($tableName, new KHash());

    foreach($rows as $row) {
      $field = $row["Field"];
      $type = Util::convertMySQLType($row["Type"]);

      if(
        // !is_array(static::$propNames[static::$tableName])
        !$klassName::$propNames->get($klassName)->check($tableName)
        )
      {                 
        $klassName::$propNames->get($klassName)->set($tableName, new KHash());
      }

      // if ($belongToTableName != null) {
      //   $modifiedField = "pri_" . $field;
      //   static::$propNames->get($klassName)->get($tableName)->set($field, $modifiedField);
      //   static::$colNames->get($klassName)->set($tableName, $field);
      //   static::$types->get($klassName)->get($tableName)->set($field, $type);
      // }
      // else {
      $klassName::$propNames->get($klassName)->get($tableName)->set($field, $field);
      $klassName::$colNames->get($klassName)->get($tableName)->push($field);
      $klassName::$types->get($klassName)->get($tableName)->set($field, $type);
      // }
      
    }
    
    // if (static::getTableName() != null) {
      /*
    if ($belongToTableName != null) {
      static::$colNames->get($klassName)->set($belongToTableName, new KArray());
      // refactor
      static::$secPropNames->set($klassName, new KHash());
      // debug array
      static::$secPropNames->get($klassName)->set($belongToTableName, new KHash());
      // end of debug
      $sql = "DESCRIBE " . $belongToTableName;
      $srows = TheWorld::instance()->slave->query($sql)->fetchAll();
      // var_dump($srows);
      foreach($srows as $srow) {
        $sfield = $srow["Field"];
        $smodifiedField = "sec_" . $sfield;
        $stype = Util::convertMySQLType($srow["Type"]);
        static::$propNames->get($klassName)->get(static::$belongToTableName)->set($sfield, $smodifiedField);
        static::$colNames->get($klassName)->get($belongToTableName)->push($sfield);
        static::$types->get($klassName)->get($belongToTableName)->set($field, $stype);
        
      }
    }
    */

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
    $tableName = static::$tableName->get($klassName)->get($klassName);

    if (static::$belongTo->get($klassName)->get($klassName) !== false) {
      throw new Exception("KORM::saveUpdate(): saveUpdate() cannot be invoked when there is join.");
    }

    // update tablename set foo = bar where id = ?
    $sql = "UPDATE " . static::$tableName->get($klassName)->get($klassName) . " SET ";
    $i = 1;
    $n = static::$propNames->get($klassName)->get($tableName)->len();

    // foreach(static::$propNames->get($klassName)->get($tableName)->get($klassName)->generator() as $propName) {
    foreach(static::$propNames->get($klassName)->get($tableName)->generator() as $propName) {
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
    $tableName = static::$tableName->get($klassName)->get($klassName);

    if (static::$belongTo->get($klassName)->get($klassName) !== false) {
      throw new Exception("KORM::saveNew(): saveNew() cannot be invoked when there is join.");
    }

    $sql = "INSERT INTO " . $tableName . " (";
    $i = 1;
    // $n = count(static::$propNames->get($klassName)->get(static::$tableName));
    $n = static::$propNames->get($klassName)->get($tableName)->len();
    foreach(static::$propNames->get($klassName)->get($tableName)->generator() as $colName) {
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
    $n = static::$propNames->get($klassName)->get($tableName)->len();

    foreach(static::$propNames->get($klassName)->get($tableName)->generator() as $propName) {
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

  static protected function makeColNames($tableName, $parentTableName = null) {
    $klassName = get_called_class();
    $belongTo = static::$belongTo->get($klassName)->get($klassName);
    $belongToTableName = static::$belongToTableName->get($klassName)->get($klassName);
    if (static::$belongToTableName->get($klassName)->check($klassName) === false) {
      $belongToTableName = null;
    }
    // $tableName = static::$tableName->get($klassName)->get($klassName);

    $sql = "";

    $colNames = static::$colNames->get($klassName)->get($tableName);

    $i = 1;
    $n = $colNames->len();

    foreach($colNames->generator() as $id => $colName) {
      if ($parentTableName == null) {
        $sql = $sql . $tableName . "." . $colName . sprintf(" as %s", $colName);
      }
      else {
        if (strcmp($tableName, $parentTableName) != 0) {
          $sql = $sql . $tableName . "." . $colName . sprintf(" as %s_%s ", $tableName, $colName);
        }
        else {
          $sql = $sql . $tableName . "." . $colName . sprintf(" as %s ", $colName);
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
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($belongTo), "_model");

    $belongTo::initialize();

    static::$belongTo->get($klassName)->set($klassName, $belongTo);
    
    static::$belongToTableName->get($klassName)->set($klassName, $tableName);
    $belongToTableName = static::$belongToTableName->get($klassName)->get($klassName);

    // debug
    $belongTo::autoSetColNames($belongTo, $belongToTableName);
    // end of debug

    return true;
  }

  static public function getBelongTo() {
    $klassName = get_called_class();

    return static::$belongTo->get($klassName)->get($klassName);
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
    $tableName = static::$tableName->get($klassName)->get($klassName);
    // debug
    if ($tableName === null) {
      return static::$propNames->get($klassName)->get($tableName);
    }
    else {
      return static::$propNames->get($klassName)->get($tableName);
    }
  }

}

?>