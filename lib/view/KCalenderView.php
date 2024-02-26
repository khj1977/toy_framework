<?php

require_once("lib/view/BaseView.php");

// This is view class of calendar. HTML part of calendar is actually impled by
// jquery-ui.
class KCalendarView extends BaseView {

    public function __construct() {
        parent::__construct();
    
        return $this;
      }
    
      protected function initialize() {
        parent::initialize();
    
        return $this;
      }

    public function render() {
        // impl render with jquery-ui calendar. Reading js src and css src may not 
        // be possible with view. Hence it would go to template of view.
        // Since they are general lib, it is OK to handle so.

        $html = "<p>Date: <input type='text' id='datepicker'></p>";

        return $html;

    }

    public function isHidden() {
        return false;
    }

}

?>