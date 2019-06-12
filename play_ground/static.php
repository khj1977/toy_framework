<?php

class AClass {

  static protected $staticVal;
  static protected $klassName;

  public function __construct() {

  }

  static public function foo() {
    $klassName = "AClass";
    $klassName::$staticVal = "apple";

    // Question. Critical
    // How to get class name for static method?
    $klassName = get_called_class();
    // end of question.
    print($klassName . " " . $klassName::$staticVal);

    return true;
  }

}

class BClass extends AClass {

  static protected $staticVal = "foo";


}

BClass::foo();

?>