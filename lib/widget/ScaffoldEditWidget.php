<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/Util.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/TheWorld.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/data_struct/KString.php");

class ScaffoldEditWidget extends BaseScaffoldWidget {

  public function xrun() {
    // $this->actionList->push("klist")->push("edit");
    // $this->setupBreadCrumb();
    $this->initializeBreadCrumb("edit");

    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $this->modelName);
   
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

    $formView = new ScaffoldFormView();
  
    $this->breadCrumbView->setIsActive("edit");
    $this->parentView->addSubView($this->breadCrumbView);

    $this->parentView->addSubView($formView)->setTitle("Something for Apple Pie");
    $this->setView($this->parentView);
    
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=confirm", $router->getModule(), $router->getController()))->setMethod("POST");

    if ($id != false) {
      $rows = $sqlTable->getDBCols(1, array("id" => $id));
      $row = $rows[0];
      foreach($row as $col) {
        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);
      }
    }
    else {
      foreach($postData as $name => $val) {
        // debug
        // quick hack. better solution?
        if (KString::isEqual($name, "id")) {
          $type = "int";
        }
        else {
          $type = "varchar";
        }
        // end of debug
        $col = new DBCol();
        $col->setName($name)->setVal($val)->setType($type);

        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);
      }
    }

    return $this;
  }

}

?>