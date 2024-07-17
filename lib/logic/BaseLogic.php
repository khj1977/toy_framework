<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseClass.php");

// This class enclose a logic basically within action of controlller. Since it will be injected to outside of controller, impl of controller or MVC would be more flexible.
abstract class BaseLogic extends BaseClass {

    abstract protected function xdo();

    final public function do() {
        $this->preDo();
        $this->xdo();
        $this->postDo();

        return $this;
    }

    protected function preDo() {

    }

    protected function postDo() {

    }

}

?>