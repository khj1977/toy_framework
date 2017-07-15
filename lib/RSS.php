<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

// About error handling.
// Almost all error will generate exception, though some methods return bool (true/false). However, it is recommended to use exception to handle error not bool returned by a method.

require_once("lib/RSSElement.php");
require_once("lib/TheWorld.php");

class RSS {

  // SimpleXMLElement is used for rootInnerXML
  // protected $rootInnerXML;
  // protected $rssElement;
  protected $domImpl;
  protected $rootNode;
  // Implementation of iterator should be splitted from this class.
  // If not so, appropriate traversal will not be executed.
  // instance val for iterator. This code may be refactored. 
  // It is better to make another class for iterator.
  // protected $iteratorChildElements;
  // protected $itrIndexOfChildElements;

  public function __construct() {

  }

  public function setRootNode($rssElement) {
    $this->rootNode = $rssElement;

    return $this;    
  }

  public function __clone() {
    $newInstance = new RSS();
    $newInstance->setImpl($this->domImpl);
    $newInstance->setImpl($this->rootNode);

    return $this;
  }

  public function getRootNode() {
    return $this->rootNode;
  }

  public function obtainRootNode($rootTag = "rss") {
    return $this->domImpl->getElementsByTagName($rootTag)->item(0);
  }

  public function __call($methodName, $args) {
    $err = method_exists($this->rootNode, $methodName);
    if (!$err) {
      throw new UException("RSS::__call(): the method " . $methodName . " does not exist to tatget of delegate.");
    }

    $result = call_user_method_array($methodName, $this->rootNode, $args);

    return $result;
  }

  // return bool with respect to the following exception..
  // throws exception when file loading or converting to XML is failed.
  public function load($path) {
    // replace by stream object (wrapper).
    if (is_dir($path)) {
      throw new UException("RSS::load(): fopen has been failed with path since it is dir: " . $path);
    }
    $stream = fopen($path, "r");
    if ($stream === false) {
      throw new UException("RSS::load(): fopen has been failed with path: " . $path);
    }

    $text = "";
    while($line = fgets($stream)) {
      $text = $text . $line;
    }

    try {
      $this->domImpl = new DOMDocument();
      $this->domImpl->loadXML($text);

      $newRSSElement = new RSSElement();
      $newRSSElement->setImpl($this->obtainRootNode());
      $this->rootNode = $newRSSElement;
    }
    catch(Exception $ex) {
      TheWorld::getInstance()->rssErrorHandler->handleError($ex);
    }

    return $this;
  }

  public function loadFromHTML($html) {
    $this->domImpl->loadHTML($html);
    $newRSSElement = new RSSElement();
    $newRSSElement->setImpl($this->obtainRootNode(""));
    $this->rootNode = $newRSSElement;

    return $this;
  }

  public function __toString() {
    return $this->toString();
  }

  public function setImpl($impl) {
    $this->impl = $impl;

    return $this;
  }

  public function toString() {
    return $this->domImpl->saveXML();
  }

  public function getElementsByTagName($tag) {
    $elements = $this->domImpl->getElementsByTagName($tag);

    $result = array();

    foreach($elements as $element) {
      $newRssElement = new RSSElement();
      $newRssElement->setImpl($element);
      $result[] = $newRssElement;
    }

    return $result;
  }

}


?>
