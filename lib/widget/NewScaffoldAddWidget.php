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

class NewScaffoldAddWidget extends BaseScaffoldWidget {

  public function xrun() {
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $args = TheWorld::instance()->arguments;

    $idKey = KConst::SCAFFOLD_EDIT_ID_KEY;
    $session = new SimpleSession();
    $isPosted = $session->get(KConst::SCAFFOLD_EDIT_IS_POSTED_KEY);
    if ($isPosted !== false) {
      $isPosted = $isPosted["real_val"];
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
    $factory->setORM($sqlTable->setORM()->getORM());

    if (!$isPosted) {
      $row = $sqlTable->getDBPropsWithEmptyData();
      foreach($row as $col) {
        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);
      }
    }
    else {
      $cols = $sqlTable->getDBPropsWithWithEmptyDataByHash();
      foreach($postData as $name => $val) {
        if (!array_key_exists($name, $cols)) {
          throw new KException("NewScaffoldAddWidget::xrun(): no matched col wit key: " . $name);
        }
        $col = $cols[$name];
        // end of debug
        // debug
        // quick hack. better solution?
        $key = $col->getKey();
        if (KString::isEqual($name, "id")) {
          $type = "int";
        }
        else if (KString::sregex($name, "/.*_id$/") === true) {
          $type = "int";
          $key = "MUL";
        }
        else {
          $type = "varchar";
        }
        $row = $sqlTable->getDBPropsWithEmptyData();
        // $col = new DBCol();
        // debug
        // position of loop?
        // end of debug    
        $col->setName($name)->setVal($val)->setType($type)->setKey($key);

        $col->setHTMLFactory($factory);
        // $html = $col->render();
        $formView->pushInput($col);
      }
    }

    return $this;
  }

}

?>