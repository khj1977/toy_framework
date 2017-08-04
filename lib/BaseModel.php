<?php

abstract class BaseModel {

  protected $filter;

  abstract public function __construct();

  public function injectFilter($aFilter) {
    $this->afilter = $aFilter;

    return $this;
  }

}

?>