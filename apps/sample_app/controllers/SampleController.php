<?php

require_once("lib/BaseController.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLConfirmElementFactory.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/view/SimpleView.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/view/SimpleRowsView.php");
require_once("lib/scaffold/StringPair.php");

class SampleController extends BaseController {

  public function preAction() {
    $this->debugStream->setFlag(false);
  }

  public function foo() {
    echo "This is action foo of SampleController</br>";

    return null;
  }

  public function sca() {
    $tableName = "test_table";
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("MySQL", $tableName);
   
    $rows = $sqlTable->getDBCols(1);

    $factory = new SimpleCol2HTMLFieldFactory();

    $formView = new ScaffoldFormView();
    $simpleView = new SimpleView();

    $simpleView->addSubView($formView);

    $row = $rows[0];
    foreach($row as $col) {
      $col->setHTMLFactory($factory);
      $html = $col->toHTML();
      $formView->pushInput($col);
    }
    // $simpleView->render();

    return $simpleView;
  }

  public function scaKORM() {
    $tableName = "test_table";
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $tableName);
   
    $row = $sqlTable->getDBCols(1, null);
    
    $factory = new SimpleCol2HTMLFieldFactory();

    $formView = new ScaffoldFormView();
    $simpleView = new SimpleView();

    $simpleView->addSubView($formView)->setTitle("Something for Apple Pie");

    $formView->setAction("/~HK/tfw/index.php?m=sample_app&c=sample&a=scaKORMConfirm")->setMethod("POST");

    foreach($row as $col) {
      $col->setHTMLFactory($factory);
      // $html = $col->toHTML();
      $formView->pushInput($col);
    }
    // $simpleView->render();

    return $simpleView;
  }

  public function scaKORMConfirm() {
    $tableName = "test_table";
    
    $factory = new SimpleCol2HTMLConfirmElementFactory();

    $rowsView = new SimpleRowsView();
    $simpleView = new SimpleView();

    $postData = TheWorld::instance()->arguments->getPostData();

    $simpleView->addSubView($rowsView)->setTitle("Confirm Something for Apple Pie");

    foreach($postData as $key => $val) {
      $pair = new StringPair();
      $pair->setPair($key, $val)->setHTMLFactory($factory);
      $rowsView->push($pair);
    }

    return $simpleView;
  }

}

?>