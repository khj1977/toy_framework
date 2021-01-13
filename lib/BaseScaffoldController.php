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

class BaseScaffoldController extends BaseAuthController {

  // specify by src code of child controller.
  // $isScaffold is not used actually,
  // but for feature extention, it is retained.
  protected $isScaffold;
  protected $modelName;
  protected $actionList;
  protected $breadCrumbView;

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

    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }

    return $this;
  }

  public function isScaffold() {
    return true;
  }

  protected function preKListExecute() {

  }

  protected function postKListExecute() {

  }

  protected function preEditExecute() {

  }

  protected function postEditExecute() {
    
  }  

  protected function preConfirmExecute() {

  }

  protected function postConfirmExecute() {
    
  }

  protected function preUpdateExecute() {

  }

  protected function postUpdateExecute() {
    
  }

  public function klist() {
    $this->preKListExecute();
    // debug
    // use reflection?
    $this->actionList->push("klist");
    $this->setupBreadCrumb("klist");
    // end of debug
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $tableFactory = new TableFactory();
    $table = $tableFactory->make("KORM", $this->modelName);
    
    // note that filter for KORM can be applied inside getDBCols() because __get() is called.
    $rows = $table->getDBCols();
    
    $rowsView = new SimpleRowsView();
    foreach($rows as $row) {
      $rowView = new ScaffoldTableRowView();
      foreach($row as $dbCol) {
       $rowView->push($dbCol);
      }
      $rowsView->push($rowView);
    }

    $simpleView = new SimpleView();

    $this->breadCrumbView->setIsActive("klist");
    $simpleView->addSubView($this->breadCrumbView);

    $simpleView->addSubView($rowsView);
    $simpleView->setTitle("List of table");

    $this->postKListExecute();

    return $simpleView;
  }

  public function edit() {
    $this->preEditExecute();

    $this->actionList->push("klist")->push("edit");
    $this->setupBreadCrumb();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $this->modelName);
   
    $args = TheWorld::instance()->arguments;
    $id = $args->get("id");

    $rows = $sqlTable->getDBCols(1, array("id" => $id));
    
    $factory = new SimpleCol2HTMLFieldFactory();

    $formView = new ScaffoldFormView();
    $simpleView = new SimpleView();

    $this->breadCrumbView->setIsActive("edit");
    $simpleView->addSubView($this->breadCrumbView);

    $simpleView->addSubView($formView)->setTitle("Something for Apple Pie");

    // debug
    // use Virtual Host instead of specify actual path.
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=confirm", $router->getModule(), $router->getController()))->setMethod("POST");
    // end of debug

    $row = $rows[0];
    foreach($row as $col) {
      $col->setHTMLFactory($factory);
      // $html = $col->render();
      $formView->pushInput($col);
    }
    // $simpleView->render();

    $this->postEditExecute();

    return $simpleView;
  }

  public function confirm() {
    $this->preConfirmExecute();

    $this->actionList->push("klist")->push("edit")->push("confirm");
    $this->setupBreadCrumb();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $factory = new SimpleCol2HTMLConfirmElementFactory();

    $rowsView = new SimpleRowsView();
    $simpleView = new SimpleView();

    $this->breadCrumbView->setIsActive("confirm");
    $simpleView->addSubView($this->breadCrumbView);

    $postData = TheWorld::instance()->arguments->getPostData();

    $simpleView->addSubView($rowsView)->setTitle("Confirm Something for Apple Pie");

    $session = TheWorld::instance()->session;
    $controllerName = TheWorld::instance()->controllerName;
    $actionName = TheWorld::instance()->actionName;
    $session->setSuffix($controllerName . "::" . $actionName . "::");
    $this->ds->vd("CTR: " . $controllerName);
    foreach($postData as $key => $val) {
      $pair = new StringPair();
      $pair->setPair($key, $val)->setHTMLFactory($factory);
      $rowsView->push($pair);

      $session->set($key, $val);
    }

    $formView = new ScaffoldFormView();

    $simpleView->addSubView($formView);

    // debug
    // use Virtual Host instead of specify actual path.
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=update", $router->getModule(), $router->getController()))->setMethod("POST");
    // end of debug

    $this->postConfirmExecute();

    return $simpleView;
  }

  public function update() {
    $this->preUpdateExecute();

    $this->actionList->push("klist")->push("edit")->push("confirm")->push("update");
    $this->setupBreadCrumb();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $session = TheWorld::instance()->session;

    $session->setSuffix(TheWorld::instance()->controllerName. "::confirm::");

    $modelName = $this->modelName;

    $modelLoader = new ModelLoader();
    $modelLoader->load($modelName);
    $korm = new $modelName($tableName);

    $keys = $session->getKeys(false);
   
    foreach($keys as $key) {
      $val = $session->get($key);
      $realKey = $val["real_key"];
      $realVal = $val["real_val"];
      // set props for ORM
      $korm->$realKey = $realVal;
    }
    $korm->save();

    $simpleView = new SimpleView();
    $simpleView->setTitle("Update has been successfuly done!");

    $this->breadCrumbView->setIsActive("update");
    $simpleView->addSubView($this->breadCrumbView);

    $this->postUpdateExecute();

    return $simpleView;
  }

  protected function setupBreadCrumb() {
    $this->breadCrumbView = new BreadCrumbView();
    foreach($this->actionList->generator() as $crumb) {
      $this->breadCrumbView->push($crumb);
    }

  }

}

?>