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
require_once("lib/widget/ScaffoldAddWidget.php");
require_once("lib/view/TwoColView.php");
require_once("lib/view/VNavView.php");
require_once("lib/widget/NewScaffoldAddWidget.php");
require_once("lib/widget/NewScaffoldConfirmWidget.php");
require_once("lib/widget/NewScaffoldEditWidget.php");
require_once("lib/widget/NewScaffoldFinishWodget.php");
require_once("lib/widget/NewScaffoldListWidget.php");

class BaseTwoCOlScaffoldController extends BaseAuthController {

  // specify by src code of child controller.
  // $isScaffold is not used actually,
  // but for feature extention, it is retained.
  protected $isScaffold;
  protected $modelName;
  protected $actionList;
  protected $breadCrumbView;
  protected $simpleView;
  // debug
  protected $twoColView;
  // end of debug

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
    $this->breadCrumbView = new BreadCrumbView();
    $headerView->setTitle("Scaffold Sample");
    $this->simpleView->addSubView($headerView)->addSubView($this->breadCrumbView);

    // debug
    $this->twoColView = new TwoColView();
    $this->simpleView->addSubView($this->twoColView);

    $this->twoColView->setRightColView(new SimpleView());
    $this->twoColView->setLeftColView(new SimpleView());

    // debug
    // impl nav to handle dynamic data appropriately.
    $this->twoColView->getLeftColView()->addSubView(new VNavView());
    // end of debug
    // end of debug

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
    $widget = new NewScaffoldListWidget();
    // return $widget->setModelName($this->modelName)->setParentView($this->simpleView)->run();

    $widget->setModelName($this->modelName)->setParentView($this->twoColView->getRightColView())->setBreadCrumbView($this->breadCrumbView)->run();

    return $this->simpleView;
  }

  public function edit() {
    $widget = new NewScaffoldEditWidget();
    $widget->setModelName($this->modelName)->setParentView($this->twoColView->getRightColView())->setBreadCrumbView($this->breadCrumbView)->run();

    return $this->simpleView;
  }

  public function add() {
    $widget = new NewScaffoldAddWidget();
    $widget->setModelName($this->modelName)->setParentView($this->twoColView->getRightColView())->setBreadCrumbView($this->breadCrumbView)->run();

    return $this->simpleView;
  }

  public function confirm() {
    $widget = new NewScaffoldConfirmWidget();
    $widget->setModelName($this->modelName)->setParentView($this->twoColView->getRightColView())->setBreadCrumbView($this->breadCrumbView)->run();

    return $this->simpleView;
  }

  public function update() {
    $widget = new NewScaffoldFinishWidget();
    $widget->setModelName($this->modelName)->setParentView($this->twoColView->getRightColView())->setBreadCrumbView($this->breadCrumbView)->run();

    return $this->simpleView;
  }

  protected function setupBreadCrumb() {
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }

  }

}

?>