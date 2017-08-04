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

}

?>
