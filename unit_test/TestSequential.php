<?php

require_once("lib/BaseUnitTest.php");
require_once("lib/TheWorld.php");
require_once("lib/BaseClass.php");
require_once("lib/data_struct/KArray.php");
require_once("lib/data_struct/KString.php");
require_once("lib/util/Util.php");
require_once("lib/util/KSeqRange.php");
require_once("lib/util/KRange.php");

class TestSequential extends BaseUnitTest {

  public function __construct() {
    parent::__construct();

    $this->initialize();

    return $this;
  }

  protected function initialize() {
    parent::initialize();

    return $this;
  }

  protected function preRun() {
    $this->debugStream->setFlag(true);
  }

  public function test_map() {
    $array = new KArray();

    $array->push(1)->push(5)->push(10)->push(3)->push(7)->push(101)->push(30);
    $anotherArray = $array->map(function($val) {
        return ($val + 2000);
    });

    foreach($anotherArray->generator() as $element) {
      Util::println($element);
    }

    $anotherArray->do(function($anotherVal) {
      Util::println("util: " . $anotherVal);
    });

    return true;
  }

  public function test_reduce() {
    // $result = $f($result, $element);
    $array = new KArray();
    // $array->push(1)->push(5)->push(10)->push(3)->push(7)->push(101)->push(30);
    $array->push(10)->push(2)->push(5);
    $result = $array->reduce(function($ret, $ele) {
      return $ret + $ele;
    });

    Util::println("reduce: " . $result);

    return true;
  }

  public function test_bulk() {
    $anArray = KArray::new()->bulkPush(array(5, 4, 3, 2, 1))->map(
      function($element) {return $element + 100;}
    );

    $anArray->do(function($element){
      Util::println("bulk: " . $element);
    });

    return true;
  }

  public function test_filter() {
    $anArray = KArray::new()->bulkPush(array(5, 4, 3, 2, 1))->filter(
      function($element) {
        if ($element > 2) {
          return true;
        }
        else {
          return false;
        }
      }
    );

    $anArray->do(function($element){
      Util::println("filter: " . $element);
    });

    return true;
  }

  public function test_where() {
    $anArray = KArray::new()->bulkPush(array(6, 7, 4, 3, 2, 1))->where(
      function($element) {
        if ($element > 2) {
          return true;
        }
        else {
          return false;
        }
      }
    );

    $anArray->do(function($element){
      Util::println("where: " . $element);
    });

    return true;
  }

  public function test_mapReduce() {
    $aVal = KArray::new()->bulkPush(array(5, 4, 3, 2, 1))->map(
      function($element) {return $element + 100;}
    )->reduce(function($ret, $val) {
      return $ret + $val;
    });

    Util::println("mapReduce: " . $aVal);

    return true;
  }

  public function test_kstring() {
    $str = new KString();
    $str->push("orange");
    foreach($str->generator() as $chr) {
      Util::println($chr);
    }

    return true;
  }

  public function test_kstringKSeq() {
    KString::new()->push("apple")->do(
      function($chr) {
        Util::println("do: " . $chr);
      }
    );

    return true;
  }

  public function test_kseqRange() {
    try {
      $result = KSeqRange::new()->set(0, 10, 1)->map(function($i) {
        return $i + 100;
      })->filter(function($i) {
        if ($i > 103) {
         return true;
        }

        return false;
      })->reduce(
        function($ret, $ele) {
          return $ret + $ele;
      });

      Util::println("kreduce: " . $result);
   }
   catch(Exception $e) {
      var_dump($e->getMessage());
      var_dump($e->getTraceAsString());
    }

    return true;
  }

  public function test_krange() {
    KRange::new()->set(10, 20, 1)->each(function($i) {Util::println("range: " . $i);});

    return true;
  }

}
?>