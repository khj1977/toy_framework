<?php

require_once("lib/view/BaseView.php");
require_once("lib/KException.php");

// <div class="p-4 mb-2 bg-dark text-white">Scaffold Sample</div>

class HeaderView extends BaseView {

  protected $title;

  public function __construct() {
    parent::__construct();

    return $this;
  }

  protected function initialize() {
    $this->title = null;

    return $this;
  }

  public function setTitle($title) {
    $this->title = $title;
    
    return $this;
  }

  public function render() {
    if ($this->title === null) {
      throw new KException("HeaderView::render(): title has not been specified yet.");
    }

    $html = sprintf('<div class="p-4 mb-2 bg-dark text-white">%s</div>', $this->title);

    return $html;
  }

}

?>