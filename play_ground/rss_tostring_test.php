<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

$xml = new SimpleXMLElement("
<depth1>
a1
<depth21>a21</depth21>
<depth22>a22</depth22>
<depth23>a23<depth31>a31</depth31></depth23>
<depth24>a24</depth24>
a1e
</depth1>");
$children = $xml->children();
$subChildren = $children[2]->children();
printf($children[2] . "\n");
// printf($subChildren[0] . "\n");

?>
