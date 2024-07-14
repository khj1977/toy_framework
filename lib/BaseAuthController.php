<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseController.php");
require_once("lib/util/KAuth.php");

// debug
// implement this class
// end of debug

class BaseAuthController extends BaseController {

    public function preAction() {
        $auth = new KAuth();

        if (!$auth->isAuthed()) {
            // debug
            // call header location or other non authed handling.
            // end of debug
        }
    }

}

?>