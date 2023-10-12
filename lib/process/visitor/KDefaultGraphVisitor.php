<?php

require_once("lib/process/visitor/KBaseProcessVisitor.php");

class KDefaultGraphVisitor extends KBaseProcessVisitor {

    public function exec($process, $arg) {
        $f = $this->f;

        return $f($process, $arg);
    }

}

?>