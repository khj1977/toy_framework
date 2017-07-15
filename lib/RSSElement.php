<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/UException.php");

class RSSElement {

  // Type of the following instance val isDOMElement.
  protected $impl;

  protected $tagString;
  protected $innerText;

  protected $iteratorChildElements;
  protected $itrIndexOfChildElements;

  public function __construct() {
    return $this;
  }

  public function initialize($tagString, $innerText) {
    // $this->tagString = $tagString;
    // $this->innerText = $innerText;
    // $this->setInnerText($innerText);
    $this->impl = new DOMElement($tagString, $innerText);

    return $this;
  }

  public function __call($methodName, $args) {
    $err = method_exists($this->impl, $methodName);
    if (!$err) {
      throw new UException("RSSElement::__call(): the method " . $methodName . " does not exist to impl of this object.");
    }

    $result = call_user_method_array($methodName, $this->impl, $args);

    return $result;
  }

  public function setImpl($domElement) {
    $this->impl = $domElement;

    return $this;
  }

  public function getImpl() {
    return $this->impl;
  }

  public function addChildElement($newRssElement) {
    // debug
    // test code
    $this->impl->appendChild($newRssElement->getImpl());
    // end of debug
    return $this;
  }

  // return type. RSS
  // Note that the following implementaion uses DOMNode instead of SimpleXMLElement
  public function getChildren() {
    $result = array();
    $childNodes = $this->impl->childNodes;
    for($i = 0; $i < $childNodes->length; ++$i) {
      // $result[] = $childNodes->item($i);
      $child = $childNodes->item($i);

      $rssElement = new RSSElement();
      $rssElement->setImpl($child);

      $result[] = $rssElement;
    }

    return $result;
  }

  public function hasChildren() {
    return $this->impl->hasChildNodes();
  }

  // iterate over the XML document holded by $rootInnerXML.
  // returns element of XML or HTML.
  // return type bool.
  public function iterate() {
    // assume that iteration will be started from root and this object is root, even it is not actual root.

    if ($this->itrIndex === -1) {
      throw new UException("RSS::iterate(): iterator has not been initialized.");
    }

    $targetElement = $this->iteratorChildElements[$this->itrIndexOfChildElements];

    $this->itrIndexOfChildElements = $this->itrIndexOfChildElements + 1;
  
    return $targetElement;
  }

  public function startIterater() {
    // debug
    // make iterator class?
    $this->iteratorChildElements = $this->getChildren();
    $this->itrIndexOfChildElements = 0;
    // end of debug

    return $this;
  }


  // Note
  // Does this method obsolete? It seems this method is not used in lib
  // end of note
  public function toXMLString() {
    return $this->innerXml->asXML();
  }

  // iterate over the XML document holded by $rootInnerXML.
  // returns element of XML or HTML.
  // return type bool.
/*
  public function iterate() {
    // assume that iteration will be started from root and this object is root, even it is not actual root.

    if ($this->itrIndex === -1) {
      throw new UException("RSS::iterate(): iterator has not been initialized.");
    }

    $targetElement = $this->iteratorChildElements[$this->itrIndexOfChildElements];

    $this->itrIndexOfChildElements = $this->itrIndexOfChildElements + 1;
  
    return $targetElement;
  }

  public function startIterater() {
    // debug
    // make iterator class?
    $this->iteratorChildElements = $this->getChildren();
    $this->itrIndexOfChildElements = 0;
    // end of debug

    return $this;
  }
*/

  // to check whether it is end of XML or HTML document
  public function isEndWidth() {
  if ($this->itrIndexOfChildElements > (count($this->iteratorChildElements) - 1)) {
      throw new UException("RSS::isEndWidth(): invalid index of itrIndexOfChildElements: " . $this->itrIndexOfChildElements);
   }

    if ($this->itrIndexOfChildElements === (count($this->iteratorChildElements) - 1)) {
      return true;
    }

    return false;
  }

  // The following implementation uses DOMNode not SimpleXMLElement.
  public function getInnerText() {
    // return sprintf("%s", $this->innerXml);

    // return $this->impl->nodeValue;
    return $this->impl->textContent;
  }

  // The following implementation uses DOMNode not SimpleXMLElement.
  public function setInnerText($aText) {
    $this->impl->textContent = $aText;
    // $this->impl->nodeValue = $aText;

    return $this;
  }

  public function testTextContent() {
    return $this->impl->textContent;
  }

  public function testNodeValue() {
    return $this->impl->nodeValue;
  }

  public function getName() {
    // print(str_replace("#", "", $this->impl->nodeName . "\n"));
    return str_replace("#", "", $this->impl->nodeName);
  }

}

?>
