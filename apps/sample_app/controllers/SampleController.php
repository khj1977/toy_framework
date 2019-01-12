<?php

require_once("lib/BaseController.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/view/SimpleView.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");

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

}

?>