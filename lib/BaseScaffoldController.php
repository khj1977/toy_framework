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

class BaseScaffoldController extends BaseAuthController {

  // specify by src code of child controller.
  protected $isScaffold;
  protected $modelName;

  public function __construct() {
    $this->modelName = null;
    $this->isScaffold = true;

    parent::__construct();
  }

  public function preAction() {
    $this->debugStream->setFlag(false);
  }

  public function klist() {
    // $tableName = "test_table";
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $tableFactory = new TableFactory();
    $table = $tableFactory->make("KORM", $tableName);
    
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
    $simpleView->addSubView($rowsView);
    $simpleView->setTitle("List of table");

    return $simpleView;
  }

  public function edit() {
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $tableName);
   
    $rows = $sqlTable->getDBCols(1, null);
    
    $factory = new SimpleCol2HTMLFieldFactory();

    $formView = new ScaffoldFormView();
    $simpleView = new SimpleView();

    $simpleView->addSubView($formView)->setTitle("Something for Apple Pie");

    $formView->setAction("/~HK/tfw/index.php?m=sample_app&c=sample&a=confirm")->setMethod("POST");

    $row = $rows[0];
    foreach($row as $col) {
      $col->setHTMLFactory($factory);
      // $html = $col->render();
      $formView->pushInput($col);
    }
    // $simpleView->render();

    return $simpleView;
  }

  public function confirm() {
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $factory = new SimpleCol2HTMLConfirmElementFactory();

    $rowsView = new SimpleRowsView();
    $simpleView = new SimpleView();

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

    $formView->setAction("/~HK/tfw/index.php?m=sample_app&c=sample&a=update")->setMethod("POST");

    return $simpleView;
  }

  public function update() {
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $session = TheWorld::instance()->session;

    $session->setSuffix(TheWorld::instance()->controllerName. "::confirm::");

    $korm = new KORM($tableName);

    $keys = $session->getKeys();
    foreach($keys as $key) {
      $val = $session->get($key);
      $realKey = $val["real_key"];
      $realVal = $val["real_val"];
      $korm->$realKey = $realVal;
    }
    $korm->save();

    $simpleView = new SimpleView();
    $simpleView->setTitle("Update has been successfuly done!");

    return $simpleView;
  }

}

?>