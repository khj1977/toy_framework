<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/KORM.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/view/SimpleRowsView.php");
require_once("lib/scaffold/sub_view/ScaffoldTableRowView.php");
require_once("lib/view/HeaderView.php");
require_once("lib/util/Util.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/view/BreadCrumbView.php");

class ScaffoldListWidget extends BaseScaffoldWidget {

  // Return view object
  public function xrun() {
    $this->actionList->push("klist");
    $this->setupBreadCrumb("klist");

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
      // notice
      // row's' not row
      $rowsView->push($rowView);
      // end of notice
    }

    $simpleView = new SimpleView();

    // debug
    // Is there better way not to repeat the following block over actions?
    // refactor the following.
    $headerView = new HeaderView();
    $headerView->setTitle("Scaffold Sample");
    $simpleView->addSubView($headerView);
    // end of debug

    $this->breadCrumbView->setIsActive("klist");
    $simpleView->addSubView($this->breadCrumbView);

    $simpleView->addSubView($rowsView);
    $simpleView->setTitle("List of table");

    $this->setView($simpleView);

    // return $simpleView;

    return $this;
  }

}

?>