<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class Foo {

  public function m1() {
  }

  public function m2() {
  }

  public function m3() {
  }

}

$klass = new ReflectionClass("Foo");
$methods = $klass->getMethods();

var_dump($methods);

?>
