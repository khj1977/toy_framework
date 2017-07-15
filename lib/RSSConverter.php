<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSS.php");
// require_once("lib/BaseRSSIterator.php");
require_once("lib/BaseRSSConverter.php");
require_once("lib/Util.php");

class RSSConverter extends BaseRSSConverter {

  protected $outputHandler;

  public function __construct() {
  }

  // debug
  // unify some method of RSSElement and RSS?
  // end of debug
  public function convert($rss) {
    // debug
    // add proc to make new rss with the following method.
    $this->xconvert($rss->getRootNode());
    // end of debug

    return $rss;
  }

  // debug
  // the following arg is appropriate to treat recursive condition?
  protected function xconvert($rssElement) {
  // end of debug
    // obtain iterator and make code based on iterator?
    // debug
    // if the result of getChildren is not RSSElement, refactor it.
    $children = $rssElement->getChildren();
    // end of debug
    // if no children, the above method returns null
    if ($children === null) {
      return;
    }

    foreach($children as $child) {
      // apply actual conversion
      // debug
      // test replace() does it replace all text within xml including
      // child node?
      $this->replace($child, $rssElement);
      // end of debug

      $this->xconvert($child);
    }

    return $this;
  }

  protected function replace($rssElement, $rssElementParent) {
    // implement the following method for rss element.
    // test
    // test getInnerText
    $innerText = htmlspecialchars_decode($rssElement->getInnerText());
    // end of tet

    // debug
    // make config class and set to env
    // $config = TheWorld::getInstance()->getConfig();
    // not completed yet. use env and args with args
    if ($rssElement->hasChildren()) {
      return $rssElement;
    }

    $replacedInnerText = Util::strReplace($innerText, "Foo", "Replaced");
    // end of debug

    $tagString = $rssElement->getName();

    // debug
    // $newRssElement = new RSSElement();
    // the following code may cause problem for replacemed text and encoding
    // of string?
    // $newRssElement = $newRssElement->initialize($tagString, $replacedInnerText);
    // end of debug

    echo $replacedInnerText . "\n";

    $rssElement->setInnerText($replacedInnerText);
    // $rssElementParent->addChildElement($newRssElement);

    return $newRssElement;
  }

}

?>
