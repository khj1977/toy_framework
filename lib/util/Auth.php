<?php

// debug
// implement this class.
// end of debug

require_once("lib/BaseClass.php");

class Auth extends BaseClass {

    public function isAuthed() {

    }

    // debug
    // Don't take log on MyPDO.
    // end of debug
    public function askAuth($id, $pass) {

    }

    public function doExpire() {

    }

    protected function getHash($rawPassword) {

    }

}


?>