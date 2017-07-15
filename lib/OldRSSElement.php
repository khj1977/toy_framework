<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/UException.php");

class RSSElement {

  protected $innerXml;

  protected $tagString;
  protected $innerText;

  protected $iteratorChildElements;
  protected $itrIndexOfChildElements;

  public function __construct() {
    return $this;
  }

  public function initialize($tagString, $innerText) {
    $this->tagString = $tagString;
    $this->innerText = $innerText;

    return $this;
  }

  public function __call($methodName, $args) {
    $err = method_exists($this->innerXml, $methodName);
    if (!$err) {
      throw new UException("RSSElement::__call(): the method " . $methodName . " does not exist to impl of this object.");
    }

    $result = call_user_method_array($methodName, $this->innerXml, $args);

    return $result;
  }

  public function setImpl($simpleXmlElement) {
    $this->innerXml = $simpleXmlElement;

    return $this;
  }

  public function addChildElement($newRssElement) {
    $this->innerXml->addChild($newRssElement->getTagString(), $newRssElement->getReplacedSInnerText());

    return $this;
  }

  // return type. RSS
  public function getChildren() {
    $children = $this->innerXml->children();

    $result = array();
    foreach($children as $child) {
      $object = new RSSElement();
      $object->setImpl($child);

      $result[] = $object;
    }

    return $result;
  }

  public function hasChildren() {
    $err = false;
    if ($this->innerXml->count() != 0) {
      $err = true;
    }

    return $err;
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

  public function getInnerText() {
    return sprintf("%s", $this->innerXml);
  }

}

?>
