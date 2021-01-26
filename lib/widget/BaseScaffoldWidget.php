<?php

require_once("lib/widget/BaseWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KStack.php");
require_once("lib/view/BreadCrumbView.php");
require_once("lib/util/SimpleSession.php");
require_once("lib/util/KConst.php");

abstract class BaseScaffoldWidget extends BaseWidget {

  protected $actionList;
  protected $breadCrumbView;
  protected $session;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    // $this->actionList = new KArray();
    $this->breadCrumbView = new BreadCrumbView();

    $this->session = new SimpleSession();
    if (!$this->session->hasKey(KConst::SESS_BREAD_CRUMB_KEY)) {
      $this->actionList = new KStack();
      $this->session->set(KConst::SESS_BREAD_CRUMB_KEY, $this->actionList);
    }
    else {
      $this->actionList = $this->session->get(KConst::SESS_BREAD_CRUMB_KEY);
      $this->actionList = $this->actionList["real_val"];
    }
    
    return $this;
  }

  protected function setupBreadCrumb($stage) {
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      if (KString::isEqual($crumb, $stage)) {
        $isActive = true;
      }
      else {
        $isActive = false;
      }
      $this->breadCrumbView->push($crumb, $isActive);
    }

    return $this;
  }

  protected function initializeBreadCrumb($stage) {
    if ($this->actionList->check($stage)) {
      $this->actionList->popUntil($stage);
    }
    else {
      $this->actionList->push($stage);
    }

    $this->setupBreadCrumb($stage);

    $this->session->set(KConst::SESS_BREAD_CRUMB_KEY, $this->actionList);
    
    return $this;
  }

}

?>