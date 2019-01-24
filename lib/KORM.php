<?php

// The author of this code is Hwi Jun KIM, euler.bonjour@gmail.com a.k.a pcaffeine

// Copyright (c) 2013, @pcaffeine
// All rights reserved.

// Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

// Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
// Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

require_once("lib/BaseClass.php");
require_once("lib/filter/DefaultFilter.php");
require_once("lib/Util.php");
require_once("lib/KException.php");

class KORM {

  protected $tableName;

  protected $belongTo;
  protected $belongWith;

  protected $slave;
  protected $master;

  // tableName => array()
  protected $colNames;
  protected $propNames;
  // colName or propName => type as string
  protected $types;

  protected $defaultFilter;
  protected $filter;

  protected $container;
  
  public function __construct($tableName) {
    // parent::__construct();

    $theWorld = TheWorld::instance();
    $this->slave = $theWorld->slave;
    $this->master = $theWorld->master;

    // $this->setPropNames();

    $this->defaultFilter = new DefaultFilter();
    $this->filter = $this->defaultFilter;
    $this->tableName = $tableName;

    $this->types = array();

    $this->belongTo = null;
    $this->belongWith = null;

    $this->container = array();

    $this->autoSetColNames();

    return $this;
  }

  protected function setPropNames() {

  }

  public function fetchOne($where, $orderBy) {
    // debug
    // refactor. Implement this part by CoC
    // $tableName = "";
    // end of debug
    $self = new $klasssName($this->tableName);

    $object = $self->xfetchOne($where, $orderBy);

    $object->setBelongTo($self->getBelongTo());
    $object->setBelongWith($self->getBelongWith());
    $object->setDefaultFilter($self->getDefaultFilter());
    $object->setFilter($self->getFilter());

    return $object;
  }

  public function fetch($where = null, $orderBy = null, $limit = null, $context = null) {
    // debug
    // refactor. Implement this part by CoC
    // $tableName = "";
    // end of debug
    $klassName = get_class($this);
    $self = new $klassName($this->tableName);
    $objects = $self->xfetch($where, $orderBy, $limit, $context);

    foreach($objects as $object) {
      $object->setBelongTo($self->getBelongTo());
      $object->setBelongWith($self->getBelongWith());
      $object->setDefaultFilter($self->getDefaultFilter());
      $object->setFilter($self->getFilter());
    }

    return $objects;
  }

  public function xfetchOne($where, $orderBy) {
    return $this->fetch($where, $orderBy, 1);
  }

  public function xfetch($where = null, $orderBy = null, $limit = null, $context = null) {

    $sql = "SELECT ";
    $i = 1;
    $n = count($colNames);

    $sql = $sql . $this->makeColNames($this->tableName);;
    if ($this->belongTo != null) {
      $sql = $sql . "," . $this->makeColNames($this->belongTo);
    }

    $sql = $sql . " FROM " . $this->tableName;
    if ($this->belongTo != null) {
      $sql = $sql . ", " . $this->belongTo;
    }

    if ($where !== null) {
      $sql = $sql . " WHERE ";

      $i = 1;
      $n = count($where);
      foreach($where as $col => $cond) {
        $sql = $sql . $col . " = " . $this->slave->quote($cond);

        if ($i != $n) {
          $sql = $sql . " AND ";
        }

        ++$i;
      }
    }

    // join
    if ($this->belongTo !== null) {
      if ($where === null) {
        $sql = $sql . " WHERE ";
      }
      $sql = $sql . $tableName . "." . $this->belongWith . " = " . $this->belongTo . "id";
    }


     
    if ($orderBy != null) {
      $sql = $sql . " ORDER BY " . $orderBy;
    }

    if ($limit != null) {
      $sql = $sql . " LIMIT " . $limit;
    }
    
    $statement = $this->slave->query($sql);

    $result = array();
    // foreach($rows as $row) {
    while($row = $statement->fetch()) {
      $klassName = $this->getKlassName();
      $object = new $klassName($this->tableName);
      $object->autoSetColNames();
      foreach($row as $propName => $val) {
        // if ($context === null) {
          // only for fetchOne
          // $context->$propName = $val;
          // $result = array($context);
        // }
        // else {
          $object->$propName = $this->filter->apply($val);
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

    return $this->container[$propName];
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
    if (!array_key_exists(
      $this->tableName, 
      $this->types
      )) {
      throw new KException("KORM::getType(): type data type does not has tableName: " . $this->tableName . " as key");
    }

    if (!array_key_exists($colName, $this->types[$this->tableName])) {
      throw new KException("KORM::getType(): colName: " . $colName . " does not have type");
    }

    return $this->types[$this->tableName][$colName];
  }

  public function autoSetColNames() {
    $this->propNames = array();

    $sql = "DESCRIBE " . $this->tableName;
    $rows = $this->slave->query($sql)->fetchAll();
    $this->colNames[$this->tableName] = array();
    $this->types[$this->tableName] = array();

    foreach($rows as $row) {
      $field = $row["Field"];
      $type = Util::convertMySQLType($row["Type"]);
      $this->colNames[$this->tableName][] = $field;
      $this->types[$this->tableName][$field] = $type;

      if(
        !is_array($this->propNames[$this->tableName])
        )
      {                 
        $this->propNames[$this->tableName] = 
          array();
      }
      if ($this->belongTo != null) {
        $modifiedField = "pri_" . $field;
        $this->propNames[$this->tableName][$field] = $modifiedField;
      }
      else {
        $this->propNames[$this->tableName][$field] = $field;
      }
    }

    if ($this->belongTo == null) {
      return $this;
    }

    if ($this->belongTo != null) {
      $this->colNames[$this->belongTo] = array();
      $sql = "DESCRIBE " . $this->belongTo;
      $rows = $this->slave->query($sql);
      foreach($rows as $row) {
        $field = $row["Field"];

        $modifiedField = "sec_" . $field;
        $this->colNames[$this->belongTo][] = $field;
        $this->secPropNames[$this->tableName][$field] = $modifiedField;
      }
    }

    return $this;
  }

  public function save() {
    if (array_key_exists("id", $this->container)) {
      $this->saveUpdate();
    }
    else {
      $this->saveNew();
    }
    
    return $this;
  }

  protected function saveUpdate() {
    if ($this->belongTo !== null) {
      throw new Exception("KORM::saveUpdate(): saveUpdate() cannot be invoked when there is join.");
    }

    // update tablename set foo = bar where id = ?
    $sql = "UPDATE " . $this->tableName . " SET ";
    $i = 1;
    $n = count($this->propNames[$this->tableName]);
    foreach($this->propNames[$this->tableName] as $propName) {
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
    if ($this->belongTo !== null) {
      throw new Exception("KORM::saveNew(): saveNew() cannot be invoked when there is join.");
    }

    $sql = "INSERT INTO " . $this->tableName . " (";
    $i = 1;
    $n = count($this->propNames);
    foreach($this->propNames as $colName) {
      $sql = $sql . $colName;
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }

    $sql = $sql . ") VALUES(";
    $i = 1;
    $n = count($propNames);
    foreach($this->propNames as $propName) {
      $val = $this->$propName;
      
      if ($i != $n) {
        $sql = $sql . ",";
      }

      ++$i;
    }
    $sql = $sql . ")";
    
    $this->master->query($sql);
  }

  protected function makeColNames($tableName, $suffix = null) {
    $sql = "";
    $colNames = $this->colNames[$tableName];
    
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
    $this->belongTo = $belongTo;

    return $this;
  }

  public function getBelongTo() {
    return $this->belongTo;
  }

  public function setBelongWith($belongWith) {
    $this->belongWith = $belongWith;

    return $this;
  }

  public function getBelongWith() {
    return $this->belongWith;
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

  public function getPropNames($tableName = null) {
    // debug
    if ($tableName === null) {
      return $this->propNames[$this->tableName];
    }
    else {
      return $this->propNames[$tableName];
    }
  }

}

?>