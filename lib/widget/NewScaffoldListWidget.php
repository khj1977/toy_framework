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
require_once("lib/data_struct/KString.php");
require_once("lib/util/ModelLoader.php");
require_once("lib/data_struct/KArray.php");

class NewScaffoldListWidget extends BaseScaffoldWidget {

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

    // debug
    // KORM::addBelongWith(array("belong_to" => "PrefectureModel", "from_key" => "prefecture_id", "to_key" => "id"));
    // end of debug

    // note that filter for KORM can be applied inside getDBCols() because __get() is called.
    // debug
    // make join inside of method?
    // public function getDBCols($limit = null, $where = null, $belongWiths = null) 
    $props = $table->getDBPropsWithEmptyData();
    $realProps = $table->getDBColsAsHash();
    $belongWiths = new KArray();
    $hasJoin = false;
    foreach($props as $prop) {
      $matched = array();
      if (preg_match("/(.*)_id$/", $prop->getName(), $matched) === 1) {
        $hasJoin = true;
        $referName = $matched[1];
        $joinModelName = Util::underscoreToUpperCamel($referName) . "Model";

        $fromKey = $prop->getName();
        $toKey = "id";

        $belongWith = array("belong_to" => $joinModelName, "from_key" => $fromKey, "to_key" => $toKey);

        $belongWiths->push($belongWith);
      }
    }

    $rows = $table->getDBCols(null, null, $belongWiths);
    $props = $table->getDBPropsWithEmptyData();
    $realProps = new KArray();
    // end of debug

    $headerView = new HtmlHeaderView();
    foreach($props as $prop) {
      $matched = array();
      if (preg_match("/(.*)_id$/", $prop->getName(), $matched) === 1) {
        // if prop is xxx_Id, col name will be xxx.
        // debug
        // $newName = $matched[1];
        $newName = $matched[1] . "_join";
        // end of debug
        // $prop->setName($newName);
      }
      $headerView->push($prop);
      $realProps->push($prop);
    }

    $rowsView = new SimpleRowsView();
    $rowsView->pushHtmlHeader($headerView);
    $realPropsGenerator = $realProps->generator();
    foreach($rows as $row) {
      // $dbCol = $rows->get($col->getName());
      // var_dump($col->getName());
      // var_dump($row);
      // debug
      // handle joined fk.
      // end of debug
      $rowView = new ScaffoldTableRowView();
      foreach($row as $dbCol) {
      // foreach() {
      // var_dump($row);
      // foreach($realPropsGenerator as $realProp) {
        // $dbCol = $row->get($realProp->getName());
        $matched = array();
        if (preg_match("/(.*)_id$/", $dbCol->getName(), $matched) == 1) {
          // debug
          // determine how to obtain db col val with joined data.
          $referName = $matched[1];
          $newName = $matched[1] . "_join";
          $joinModelName = Util::underscoreToUpperCamel($referName) . "Model";
          continue;
          $dbCol->setName($newName);
          // end of debug
        }
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