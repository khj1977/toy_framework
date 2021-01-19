<?php

require_once("lib/widget/BaseScaffoldWidget.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/util/Util.php");
require_once("lib/util/ModelLoader.php");
require_once("lib/view/MessageAlertVIew.php");

class ScaffoldFinishWidget extends BaseScaffoldWidget {

  public function xrun() {
    $this->actionList->push("klist")->push("edit")->push("confirm")->push("update");
    $this->setupBreadCrumb();
    $tableName = Util::omitSuffix(Util::upperCamelToLowerCase($this->modelName), "_model");

    $session = TheWorld::instance()->session;

    $session->setSuffix(TheWorld::instance()->controllerName. "::confirm::");

    $modelName = $this->modelName;

    $modelLoader = new ModelLoader();
    $modelLoader->load($modelName);
    $korm = new $modelName($tableName);

    $keys = $session->getKeys(false);
   
    foreach($keys as $key) {
      $val = $session->get($key);
      $realKey = $val["real_key"];
      $realVal = $val["real_val"];
      // set props for ORM
      $korm->$realKey = $realVal;
    }
    $korm->save();

    // $simpleView = new SimpleView();
    $this->parentView->setTitle("Update has been successfuly done!");
    $this->setView($this->parentView);

    $this->breadCrumbView->setIsActive("update");
    $this->parentView->addSubView($this->breadCrumbView);

    $messageAlertView = new MessageAlertView();
    $messageAlertView->setMessage("Update has successfully been done.")->setJumpToURL(Util::generateURLFromActionName("klist"))->setButtonLabel("戻る");
    $this->parentView->addSubView($messageAlertView);

    return $this;
  }

}

?>