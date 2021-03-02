<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/KException.php");
require_once("lib/TheWorld.php");

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
    throw new KException("Util::hashToJson(): this method has not been implemented yet.");
    // end of debug
  }

  static public function JSONEncode($data) {
    // debug
    throw new KException("Util::JSONEncode(): this method has not been implemented yet.");
    // end of debug
  }

  static public function JSONDecode() {
    throw new KException("Util::JSONDecode(): this method has not been implemented yet.");
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
            $subStrStartIndex = $i;
            $subStrIndex = $i;
          }
          if ($i == ($len - 1)) {
            /*
            echo substr($str, 0, $len - $subStrStartIndex + 1);
            exit;
            */
          }
          
          $subChar = $str[$subStrIndex];
          ++$subStrIndex;
        }
        else {
          $subStrIndex = 0;
          $subChar = $suffix[$subStrIndex];
        }
      }
      
      $result = substr($str, 0, $subStrStartIndex);

      return $result;
    }

    static public function omitPrefix($str, $prefix) {
      $strLen = strlen($str);
      $prefixLen = strlen($prefix);

      $i = 0;
      for($j = 0; $j < $prefixLen; ++$j) {
        if ($i >= $strLen) {
          return false;
        }

        $s = $str[$i];
        $p = $prefix[$j];
        if (strcmp($p, $s) != 0) {
          return false;
        }

        ++$i;
      }

      $result = "";
      for($k = $prefixLen; $k < $strLen; ++$k) {
        $result = $result . $str[$k];
      }

      return $result;
    }

    // debug
    // The method name of the following method is incorrect underscore to upper camel is correct. By another method, alias class method is provided.
    // end of debug
    static public function upperCamelToUnderScore($str) {
      $splitter = "_";
      $splitted = explode($splitter, $str);
      
      $result = "";
      $n = count($splitted);
      for($i = 0; $i < $n; ++$i) {
        $subStr = $splitted[$i];
        $subStr = ucwords($subStr);

        $result = $result . $subStr;
      }

      return $result;
    }

    static public function underscoreToUpperCamel($str) {
      return Util::upperCamelToUnderScore($str);
    }

    static public function htmlspecialchars($str) {
      return htmlspecialchars($str);
    }

    static public function outHTML($html) {
      print($html);
    }

    static public function generateURLFromActionName($actionName) {
      $theWorld = TheWorld::instance();
      $url = sprintf("/index.php?m=%s&c=%s&a=%s",
        $theWorld->moduleName,
        $theWorld->controllerName,
        $actionName);

      return $url;
    }

    static public function serialize($obj) {
      return serialize($obj);  
    }

    static public function unserialize($objAsString) {
      return unserialize($objAsString);  
    }

    static public function isEmpty($val) {
      if ($val === "" || $val === null || $val === false) {
        return true;
      }

      return false;
    }

  }

?>
