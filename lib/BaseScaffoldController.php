<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseController.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLConfirmElementFactory.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/view/SimpleView.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/scaffold/sub_view/ScaffoldTableRowView.php");
require_once("lib/view/SimpleRowsView.php");
require_once("lib/scaffold/StringPair.php");
require_once("lib/KORM.php");
require_once("lib/BaseAuthController.php");
require_once("lib/util/ModelLoader.php");
require_once("lib/view/BreadCrumbView.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KString.php");
require_once("lib/util/Util.php");
require_once("lib/view/HeaderView.php");
require_once("lib/view/MessageAlertVIew.php");
require_once("lib/widget/ScaffoldListWidget.php");
require_once("lib/widget/ScaffoldEditWidget.php");
require_once("lib/widget/ScaffoldConfirmWidget.php");
require_once("lib/widget/ScaffoldFinishWodget.php");

class BaseScaffoldController extends BaseAuthController {

  // specify by src code of child controller.
  // $isScaffold is not used actually,
  // but for feature extention, it is retained.
  protected $isScaffold;
  protected $modelName;
  protected $actionList;
  protected $breadCrumbView;
  protected $simpleView;

  public function __construct() {
    $this->modelName = null;
    $this->isScaffold = true;

    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->actionList = new KArray();
    // debug
    // use reflection?
    // $this->actionList->push("klist")->push("edit")->push("confirm")->push("update");
    // end of debug

    $this->simpleView = new SimpleView();
    $headerView = new HeaderView();
    $headerView->setTitle("Scaffold Sample");
    $this->simpleView->addSubView($headerView);

    /*
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }
    */

    return $this;
  }

  public function isScaffold() {
    return true;
  }

  public function klist() {
    $widget = new ScaffoldListWidget();
    return $widget->setModelName($this->modelName)->setParentView($this->simpleView)->run();
  }

  public function edit() {
    $widget = new ScaffoldEditWidget();
    return $widget->setModelName($this->modelName)->setParentView($this->simpleView)->run();
  }

  public function confirm() {
    $widget = new ScaffoldConfirmWidget();
    return $widget->setModelName($this->modelName)->setParentView($this->simpleView)->run();
  }

  public function update() {
    $widget = new ScaffoldFinishWidget();
    return $widget->setModelName($this->modelName)->setParentView($this->simpleView)->run();
  }

  protected function setupBreadCrumb() {
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }

  }

}

?>