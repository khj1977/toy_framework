<?php

require_once("lib/view/BaseView.php");

// This is view class of calendar. HTML part of calendar is actually impled by
// jquery-ui.
class KCalendarView extends BaseView {

    public function render() {

    }

    public function isHidden() {
        return false;
    }

}

?>