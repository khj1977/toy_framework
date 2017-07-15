<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

// reference
// php.net/manual/ja/class.domtext.php

class Foo {

  public $vval;

  public function __construct() {
    $this->vval = "bar";
  }

}

$xml = "
<depth1>
a1
<depth21>a21</depth21>
<depth22>a22</depth22>
<depth23>a23<depth31>a31</depth31></depth23>
<depth24>a24</depth24>
a1e
</depth1>";



$dom = new DOMDocument();
$dom->loadXML($xml);
$elements = $dom->getElementsByTagName("depth1");
foreach($elements as $element) {
  // var_dump($element);
  echo "node type: " . $element->nodeType . "\n";
  $wholeText = $element->wholeText;
  echo "whole: " . $wholeText;
  $element->nodeValue = "val: " . $element->nodeValue;
}

/*
$elements = $dom->getElementsByTagName("depth22");
// print("get elements by tag name\n");
foreach($elements as $element) {
  // var_dump($element);
  // $element->nodeValue = "val: " . $element->nodeValue;
  printf($element->tagName . "\n"); 
  printf($element->nodeValue . "\n");
}

// $element->textContent = "";
// print($dom); with to string

// $foo = new Foo();
// echo $foo->vval . "\n";
*/

?>
