<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

class Util {

  static public function copyArray($anArray) {
    $newArray = array();
    foreach($anArray as $element) {
      // not copy $element in this copy method.
      $newArray[] = $element;
    }

    return $newArray;
  }

  static public function strReplace($subject, $s1, $s2) {
    // Does it work with mullti byte char?
    // return str_replace($s1, $s2, $subject);
    // return $subject;
    return mb_ereg_replace($s1, $s2, $subject);
  }

  static public function hashToJson($aHash) {
    // debug
    // call appropriate json encoder.
    throw new Exception("Util::hashToJson(): this method has not been implemented yet.");
    // end of debug
  }

  static public function JSONEncode($data) {
    // debug
    throw new Exception("Util::JSONEncode(): this method has not been implemented yet.");
    // end of debug
  }

  static public function JSONDecode() {
    throw new Exception("Util::JSONDecode(): this method has not been implemented yet.");
  }

  static public function convertMySQLType($rawType) {
    if (preg_match("/int.*/", $rawType) == 1) {
      return "int";
    }
    else if (preg_match("/varchar.*/", $rawType)) {
      return "varchar";
    }
   
    return $rawType;
  }

  static public function realpath($path) {
    return realpath($path);
  }

  static public function ucwords($str) {
    return ucwords($str);
  }

  static public function println($str) {
    print($str . "\n");
  }

}

?>
