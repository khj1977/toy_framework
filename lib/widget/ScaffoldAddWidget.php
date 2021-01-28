<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/Util.php");
require_once("lib/scaffold/factory/TableFactory.php");
require_once("lib/TheWorld.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLFieldFactory.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/data_struct/KString.php");
require_once("lib/util/Util.php");

class ScaffoldAddWidget extends BaseScaffoldWidget {

  public function xrun() {
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $args = TheWorld::instance()->arguments;

    $idKey = KConst::SCAFFOLD_EDIT_ID_KEY;
    $session = new SimpleSession();
    $isPosted = $session->get(KConst::SCAFFOLD_EDIT_IS_POSTED_KEY);
    $isPosted = $isPosted["real_val"];
    if ($isPosted) {
      $postData = TheWorld::instance()->session->get(KConst::SCAFFOLD_CONFIRM_POST_KEY);
      $postData = $postData["real_val"];
    }

    $formView = new ScaffoldFormView();
  
    // $this->actionList->push("klist")->push("add");
    // $this->setupBreadCrumb();
    $this->initializeBreadCrumb("add");
    $this->breadCrumbView->setIsActive("add");
    // $this->parentView->addSubView($this->breadCrumbView);

    $this->parentView->addSubView($formView)->setTitle("Something for Apple Pie");
    $this->setView($this->parentView);
    
    $tableFactory = new TableFactory();
    $sqlTable = $tableFactory->make("KORM", $this->modelName);
    
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=confirm", $router->getModule(), $router->getController()))->setMethod("POST");

    $factory = new SimpleCol2HTMLFieldFactory();

    if (!$isPosted) {
      $row = $sqlTable->getDBPropsWithEmptyData();
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