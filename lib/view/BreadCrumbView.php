<?php

require_once("lib/BaseClass.php");
require_once("lib/util/Util.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KHash.php");

class BreadCrumbView extends BaseClass {

  protected $crumbs;
  protected $whichIsActive;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->crumbs = new KArray();
    $this->whichIsActive = new KHash();

    return $this;
  }

  public function push($crumbName, $isActive = false) {
    $hash = new KHash();
    $actionName = $crumbName;
    $hash->set("crumb", $crumbName);
    $hash->set("is_active", $isActive);
    $hash->set("url", Util::generateURLFromActionName($actionName));
    $this->crumbs->push($hash);

    if ($isActive === true) {
      $this->whichIsActive->set($crumbName, true);
    }
    else {
      $this->whichIsActive->set($crumbName, false);
    }

    return $this;
  }

  public function isActive($name) {
    if (!$this->whichIsActive->check($name)) {
      return false;
    }
    else if (!$this->whichIsActive->get($name)) {
      return false;
    }

    return true;
  }

  public function setIsActive($name) {
    $this->whichIsActive->set($name, true);

    return $this;
  }

  public function render() {
    $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
    
    $generator = $this->crumbs->generator();
    foreach($generator as $aHash) {
      $crumb = $aHash->get("crumb");
      $crumbUrl = $aHash->get("url");
      if ($this->isActive($crumb)) {
        $html = $html . sprintf('<li class="breadcrumb-item active" aria-current="page">%s</li>', $crumb);
      }
      else {
        $html = $html . sprintf('<li class="breadcrumb-item"><a href="%s">%s</a></li>', $crumbUrl, $crumb);
      }
    }
    $html = $html . '</ol>';
    $html = $html . '</nav>';

    return $html;
  }


}

?>