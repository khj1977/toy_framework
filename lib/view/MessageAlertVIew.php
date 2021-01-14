<?php

require_once("lib/view/BaseView.php");
require_once("lib/KException.php");

class MessageAlertView extends BaseView {
  protected $message;
  protected $buttonLabel;
  protected $jumpToURL;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->message = null;
    $this->buttonLabel = null;
    $this->jumpToURL = null;

    return $this;
  }

  public function setMessage($message) {
    $this->message = $message;

    return $this;
  }

  public function setJumpToURL($url) {
    $this->jumpToURL = $url;

    return $this;
  }

  public function setButtonLabel($label) {
    $this->buttonLabel = $label;

    return $this;
  }

  public function render() {
    if ($this->message === null || $this->buttonLabel === null || $this->jumpToURL === null) {
      throw new KException("MessageAlertView::render(): message or jump to url has not been set.");
    }

    $html = '<center> <div class="card w-75"> <div class="card-body"> <p class="card-text">%s</p> <a href="%s" class="btn btn-primary">%s</a> </div> </div> </center>';

    $html = sprintf($html, $this->message, $this->jumpToURL, $this->buttonLabel);

    return $html;
  }

}

?>