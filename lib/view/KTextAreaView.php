<?php

require_once("lib/view/BaseView.php");

// This is view class of calendar. HTML part of calendar is actually impled by
// jquery-ui.
class KTextAreaView extends BaseView {

    protected $val;

    public function __construct() {
        parent::__construct();
    
        return $this;
    }
    
    protected function initialize() {
        parent::initialize();
    
        return $this;
    }

    public function render() {
        // $html = "<label> " . $this->getMyName();
        $html = sprintf("<textarea class='form-control', name='%s'>%s</textarea>",
            $this->getMyName(), $this->val);
        // $html = $html . "</label>";

        return $html;
    }

    public function isHidden() {
        return false;
    }

    public function setVal($val) {
        $this->val = $val;

        return $this;
    }

}

?>