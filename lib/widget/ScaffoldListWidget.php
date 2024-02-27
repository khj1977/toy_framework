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
require_once("lib/view/LinkButtonView.php");
require_once("lib/util/SimpleSession.php");
require_once("lib/view/HtmlHeaderView.php");
require_once("lib/view/KCalenderView.php");

class ScaffoldListWidget extends BaseScaffoldWidget {

  // Return view object
  public function xrun() {
    // $this->actionList->push("klist");
    // $this->setupBreadCrumb("klist");
    $session = new SimpleSession();
    $session->set(KConst::SCAFFOLD_EDIT_IS_POSTED_KEY, false);
    $session->clear();
    $this->initializeBreadCrumb("klist");

    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $tableFactory = new TableFactory();
    $table = $tableFactory->make("KORM", $this->modelName);

    // note that filter for KORM can be applied inside getDBCols() because __get() is called.
    $rows = $table->getDBCols();
    $props = $table->getDBPropsWithEmptyData();

    $headerView = new HtmlHeaderView();
    foreach($props as $prop) {
      $headerView->push($prop);
    }

    $rowsView = new SimpleRowsView();
    $rowsView->pushHtmlHeader($headerView);
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

    // $simpleView = new SimpleView();

    $this->breadCrumbView->setIsActive("klist");
    // $this->parentView->addSubView($this->breadCrumbView);


    # debug
    # This is experimental use.
    $this->parentView->addSubView(new KCalendarView());
    # end of debug

    $buttonView = new LinkButtonView();
    $buttonView->setKind("btn-primary")->setText("Add data")->setLinkTo(Util::generateURLFromActionName("add"));
    $this->parentView->addSubView($buttonView);

    $this->parentView->addSubView($rowsView);

    // debug
    // $this->parentView->setTitle("List of table");
    // end of debug

    $this->setView($this->parentView);

    // return $simpleView;

    return $this;
  }

}

?>