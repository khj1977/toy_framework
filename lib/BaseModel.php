<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

abstract class BaseModel {

  protected $filter;

  abstract public function __construct();

  public function injectFilter($aFilter) {
    $this->afilter = $aFilter;

    return $this;
  }

}

?>