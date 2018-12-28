<?php

require_once("lib/scaffold/sub_view/BaseScaffoldView.php");

class ScaffoldFormView extends BaseScaffoldView {

  // HTML as string.
  protected $inputs;
  protected $output;

  protected $action;
  protected $method;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    $this->inputs = array();
    $this->action = null;
    $this->method = null;

    return $this;
  }

  public function setAction($action) {
    $this->action = $action;

    return $this;
  }

  public function setMethod($method) {
    $this->method = $method;

    return $this;
  }

  public function render() {
    $this->construct();

    print($this->output);
  }

  public function construct() {
    $this->output = sprintf("<form action='%s' method='%s'>", $this->action, $this->method);
    foreach($this->inputs as $input) {
      if ($input->getName() === "id" && $input->getType() == "int") {
        continue;
      }

      $this->output = $this->output . $input->getName() . ": " . $input->toHTML() . "</br>";
    }
    $this->output = $this->output . '<input type="submit" value="送信">';
    $this->output = $this->output . "</form>";

    return $this;
  }

  public function pushInput($aInput) {
    $this->inputs[] = $aInput;

    return $this;
  }

}

?>