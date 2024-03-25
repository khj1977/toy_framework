<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/Util.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/TheWorld.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/util/SimpleSession.php");
require_once("lib/data_struct/KString.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/ModelLoader.php");

class NewScaffoldEditWidget extends BaseScaffoldWidget {

  public function xrun() {
    // $this->actionList->push("klist")->push("edit");
    // $this->setupBreadCrumb();
    $this->initializeBreadCrumb("edit");

    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
   
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $this->modelName);

   
    $props = $sqlTable->getDBPropsWithEmptyData();
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

    // $rows = $sqlTable->getDBCols(null, null, $belongWiths);

    $args = TheWorld::instance()->arguments;

    $idKey = "scaffold_widget::edit::::xrun::id";
    if ($args->isSet("id")) {
      $id = $args->get("id");
      TheWorld::instance()->session->set($idKey, $id);
    }
    else {
      $id = false;
      $postData = TheWorld::instance()->session->get("scaffold::confirm::widget::xrun::post_data");
      $postData = $postData["real_val"];
    }
    
    $factory = new SimpleCol2HTMLFieldFactory();
    $factory->setORM($sqlTable->getORM());

    $formView = new ScaffoldFormView();
  
    $this->breadCrumbView->setIsActive("edit");
    // $this->parentView->addSubView($this->breadCrumbView);

    $this->parentView->addSubView($formView)->setTitle("Something for Apple Pie");
    $this->setView($this->parentView);
    
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=confirm", $router->getModule(), $router->getController()))->setMethod("POST");

    $session = TheWorld::instance()->session;
    $colsForSession = new KArray();
    if ($id != false) {
      // debug
      // do join and skip .*_id$
      $rows = $sqlTable->getDBCols(1, array("id" => $id));
      // end of debug
      $row = $rows[0];
      foreach($row as $col) {
        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);

        $newCol = new DBCol();

        // debug
        // Associate setName, setVal to postData?
        // $newCol->setName($col->getName())->setVal($postData[$col->getName()])->setType($col->getType())->setKey($col->getType());
        $newCol->setName($col->getName())->setVal($col->getName())->setType($col->getType())->setKey($col->getType());
        // end of debug

        $colsForSession->push($newCol);
      }

      $session->set("NewScaffoldEditWidget::cols", $colsForSession);
    }
    else {
      $cols = $session->get("NewScaffoldEditWidget::cols");
      $cols = $cols["real_val"];
      
      $cols->each(function($col) use ($formView, $factory, $postData) {
        // $col->setVal($postData[$col->getName()]);

        $col->setHTMLFactory($factory);
        $formView->pushInput($col);
      });
     
      /*
      foreach($postData as $name => $val) {
        // debug
        // quick hack. better solution?
        $key = "";
        if (KString::isEqual($name, "id")) {
          $type = "int";
        }
        // else if (preg_match("/.*_id/", $name) === 1) {
        else if (KString::sregex($name, "/.*_id$/") === true) {
          $type = "int";
          $key = "MUL";
        }
        else {
          $type = "varchar";
        }
        // debug
        // impl type = text for textarea data which is corresponds to type of MySQL not
        // naming rule. Retain type hint of MySQL on PostData or even in session?
        // end of debug
        // end of debug

        $col = new DBCol();
        $col->setName($name)->setVal($val)->setType($type)->setKey($key);

        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);
      }
      */
    }

    return $this;
  }

}

?>