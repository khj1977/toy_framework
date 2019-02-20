<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KException.php");

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
    $result =  realpath($path);
    if ($result === false) {
      throw new KException("Util::realpath(): no such file or directory: " . $path);
    }

    $baseDir = TheWorld::instance()->getBaseDir();
   
    $baseDir = str_replace("/", "\/", $baseDir);
    $pattern = "/" . $baseDir . "/";
    if (preg_match($pattern, $result) == 0) {
      throw new KException("Util::realpath(): possibility of directory traversal attack.");
    }

    return $result;
  }

  static public function ucwords($str) {
    return ucwords($str);
  }

  static public function println($str) {
    print($str . "\n");
  }

  static public function upperCamelToLowerCase($str) {
    $result = "";
    $len = strlen($str);
    for($i = 0; $i < $len; ++$i) {
      $chr = $str[$i];
      if (preg_match("/[A-Z]/", $chr) != 0) {
        $chr = lcfirst($chr);
        if ($i != 0) {
          $result = $result . "_" . $chr;
        }
        else {
          $result = $result . $chr;
        }
      }
      else {
        $result = $result . $chr;
      }
    }


    return $result;
  }

    static public function omitSuffix($str, $suffix) {
      // $str = "model_test_foo_model";
      // $subStr = "_model";
      
      $subStrIndex = 0;
      $subChar = $suffix[$subStrIndex];
      $len = strlen($str);
      
      for($i = 0; $i < $len; ++$i) {
        // printf("%d %d %d %d\n", $i, $len, $subStrIndex, $subStrStartIndex);
        $chr = $str[$i];
        // printf("%s %s\n", $chr, $subChar);
        if (strcmp($chr, $subChar) == 0) {
          if ($subStrIndex == 0) {
            $subStrIndex = $i;
            $subStrStartIndex = $i;
          }
          if ($i == ($len - 1)) {
            /*
            echo substr($str, 0, $len - $subStrStartIndex + 1);
            exit;
            */
          }
          ++$subStrIndex;
          $subChar = $suffix[$subStrIndex];
        }
        else {
          $subStrIndex = 0;
          $subChar = $suffix[$subStrIndex];
        }
      }
      
      return substr($str, 0, $subStrStartIndex);
    }

  }

?>
