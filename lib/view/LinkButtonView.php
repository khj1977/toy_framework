<?php

require_once("lib/view/BaseView.php");
require_once("lib/KException.php");


class LinkButtonView extends BaseView {

  protected $kind;
  protected $linkTo;
  protected $text;

  protected function initialize() {
    $this->kind = null;
    $this->linkTo = null;
    $this->text = null;

    return $this;
  }

  public function setKind($kind) {
    $this->kind = $kind;

    return $this;
  }

  public function setLinkTo($linkTo) {
    $this->linkTo = $linkTo;

    return $this;
  }

  public function setText($text) {
    $this->text = $text;

    return $this;
  }

  public function render() {
    if ($this->kind === null || $this->linkTo === null || $this->text === null) {
      throw new KException("LinkButtonView::render(): some instance vals have not been set.");
    }

    // kind: btn-primary
    $html = sprintf('<a class="btn %s" href="%s" role="button">%s</a>',
      $this->kind, $this->linkTo, $this->text
    );

    return $html;
  }

}

?>