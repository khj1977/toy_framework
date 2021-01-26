<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/Util.php");
require_once("lib/scaffold/factory/SimpleCol2HTMLConfirmElementFactory.php");
require_once("lib/view/SimpleView.php");
require_once("lib/scaffold/StringPair.php");
require_once("lib/scaffold/sub_view/ScaffoldFormView.php");
require_once("lib/util/KConst.php");

class ScaffoldConfirmWidget extends BaseScaffoldWidget {

  public function xrun() {
    // $this->actionList->push("klist")->push("edit")->push("confirm");
    // $this->setupBreadCrumb();
    $this->initializeBreadCrumb("confirm");
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");
    
    $factory = new SimpleCol2HTMLConfirmElementFactory();

    $rowsView = new SimpleRowsView();
    // $simpleView = new SimpleView();

    /*
    $headerView = new HeaderView();
    $headerView->setTitle("Scaffold Sample");
    $simpleView->addSubView($headerView);
    */

    $this->breadCrumbView->setIsActive("confirm");
    $this->parentView->addSubView($this->breadCrumbView);

    $postData = TheWorld::instance()->arguments->getPostData();
    TheWorld::instance()->session->set(KConst::SCAFFOLD_CONFIRM_POST_KEY, $postData);

    $this->parentView->addSubView($rowsView)->setTitle("Confirm Something for Apple Pie");

    $session = TheWorld::instance()->session;
    $controllerName = TheWorld::instance()->controllerName;
    $actionName = TheWorld::instance()->actionName;
    $session->setSuffix($controllerName . "::" . $actionName . "::");
    // $this->ds->vd("CTR: " . $controllerName);
    foreach($postData as $key => $val) {
      $pair = new StringPair();
      $pair->setTableName($tableName)->setPair($key, $val)->setHTMLFactory($factory);
      $rowsView->push($pair);

      $session->set($key, $val);
    }

    $formView = new ScaffoldFormView();

    $this->parentView->addSubView($formView);
    $this->setView($this->parentView);

    // debug
    // use Virtual Host instead of specify actual path.
    $router = TheWorld::instance()->router;
    $formView->setAction(sprintf("/index.php?m=%s&c=%s&a=update", $router->getModule(), $router->getController()))->setMethod("POST");
    // end of debug

    $session = new SimpleSession();
    $isPosted = $session->set(KConst::SCAFFOLD_EDIT_IS_POSTED_KEY, true);

    return $this;
  }

}

?>