<?php

require_once("lib/widget/BaseWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/view/BreadcumbView.php");

abstract class BaseScaffoldWidget extends BaseWidget {

  protected $actionList;
  protected $breadCrumbView;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::_initilize();

    $this->actionList = new KArray();
    $this->breadCrumbView = new BreadCrumbView();
    return $this;
  }

  protected function setupBreadCrumb() {
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }

    return $this;
  }

}

?>