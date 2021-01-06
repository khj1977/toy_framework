<?php

require_once("lib/view/BaseView.php");
require_once("lib/util/Util.php");

class AccordionView extends BaseView {

  protected $buttonTitle;
  protected $id;
  protected $bodyHTMLData;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->buttonTitle = null;
    $this->id = null;
    $this->bodyHTMLData = null;

    return $this;
  }

  public function setButtonTitle($title) {
    $this->buttonTitle = $title;

    return $this;
  }

  public function setID($id) {
    $this->id = $id;

    return $this;
  }

  public function setBodyData($htmlData) {
    $this->bodyHTMLData = $htmlData;

    return $this;
  }

  public function render() {
    $body = '<p> <a class="btn btn-primary" data-toggle="collapse" href="#%s" role="button" aria-expanded="false" aria-controls="%s"> %s </a> </p> <div class="collapse" id="%s"> <div class="card card-body">%s</div> </div>';

    $html = sprintf($body, $this->id, $this->id, $this->buttonTitle, $this->id, $this->bodyHTMLData);

    Util::outHTML($html);

    return $this;
  }

}

?>