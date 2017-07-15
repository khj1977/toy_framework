<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSS.php");
require_once("lib/Util.php");

// Assume that an internal data of rss will not be changed during iteration
// operation. Lock mechanism for target of iteration, in this case, $rss, 
// is not implemented.

class BaseRSSIterator {

  // RSS
  protected $iterationTarget;
  // Array of SimpleXMLElement
  protected $iteratorChildElements;
  // Integer: Array index of child elements.
  protected $itrIndexOfChildElements;
  // protected $itrIndex;

  public function __construct($rssElement) {
    $this->iterationTarget = $rssElement;

    $this->itrIndexOfChildElements = -1;

    $this->initialize();

    return $this;
  }

  public function initialize() {
    $this->iteratorChildElements = $this->iterationTarget->getChildren();
    $this->itrIndexOfChildElements = 0;

    return $this;
  }

  public function __clone() {
    $newInstance = new BaseRSSIterator($this->rss);

    $iteratorChildElements = array();

    $newInstance->setIteratorChildElements(Util::copyArray($this->iteratorChildElements));
    $newInsntace->setItrIndexOfChildElements($this->itrIndexOfChildElements);

    return $newInstance;
  }  


  public function iterate() {
    // assume that iteration will be started from root and this object is root, even it is not actual root.

    if ($this->itrIndexOfChildElements === -1) {
      throw new UException("BaseRSSIterator::iterate(): iterator has not been initialized.");
    }

    $targetElement = $this->iteratorChildElements[$this->itrIndexOfChildElements];

    $this->itrIndexOfChildElements = $this->itrIndexOfChildElements + 1;
  
    return $targetElement;
  }

  public function setIteratorChildElements($childElements) {
    $this->iteratorChildElements = $childElements;

    return $this;
  }

  public function setItrIndexOfChildElements($itrIndexOfChildElements) {
    $this->itrIndexOfChildElements = $itrIndexOfChildElements;

    return $this;
  }

  public function getCurrentElement() {
    return $this->iteratorChildElements[$this->itrIndexOfChildElements];
  }

  public function getInnerText() {
    $xmlElement = $this->getCurrentElement();
    return sprintf("%s", $xmlElement);
  }

  public function hasChildren() {
    $err = false;
    if ($this->getCurrentElement()->count() != 0) {
      $err = true;
    }

    return $err;
   } 
}
}


}

?>
