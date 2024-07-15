<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/Util.php");
require_once("lib/BaseController.php");
require_once("lib/util/KAuth.php");

// debug
// implement this class
// end of debug

class BaseAuthController extends BaseController {

    public function preAction() {
        $auth = new KAuth();
        if (!$auth->isAuthed()) {
            Util::jumpTo("/");
        }

        return $this;
    }

}

?>