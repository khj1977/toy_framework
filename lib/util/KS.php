<?php

require_once("lib/data_struct/KString.php");

class KS extends KString {

    static public function n($str) {
        return KString::new()->append($str);
    }

    static public function make($str) {
        return  static::n($str);
    }

    static public function cmp($str1, $str2) {
        return KS::eq($str1, $str2);
    }

    static public function eq($str1, $str2) {
        return KString::isEqual($str1, $str2);
    }

    static public function copy($kstring) {
        $stringObj = (new KString())->append($kstring->data());
    }

}

?>