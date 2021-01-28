<?php

require_once("lib/view/BaseView.php");

class RawView extends BaseView {

  protected $content;

  public function render() {
    return $this->content->render();
  }

  public function addSubView($aContent) {
    $this->content = $aContent;

    return $this;
  }

}

?>