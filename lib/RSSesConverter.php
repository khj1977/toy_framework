<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/RSS.php");
require_once("lib/RSSElement.php");
require_once("lib/RSSConverter.php");
require_once("lib/BaseRSSConverter.php");

class RSSesConverter extends BaseRSSConverter{

  protected $outputHandler;
  protected $replacingText;
  protected $replacedText;

  public function __construct() {
  }

  public function setOutputHandler($outputHandler) {
    $this->outputHandler = $outputHandler;
  }

  // rootRss
  // obtain content belongs to <item>
  public function convert($rootRss) {
    $rssElements = $rootRss->getElementsByTagName("item");

    $i = 0;
    $rss = new RSS();
    $rssConverter = new RSSConverter();
    foreach($rssElements as $rssElement) {
      $descElement = new RSSElement();
      $descElement->setImpl($rssElement->getElementsByTagName("description")->item(0));

      $decodedHtml = htmlspecialchars_decode($descElement->getInnerText());
      $replacedHtml = Util::strReplace($decodedHtml, $this->replacingText, $this->replacedText);

      $this->outputHandler->write("----start to write: " . $i . "-----\n");
      $this->outputHandler->write($replacedHtml);
      $this->outputHandler->write("-----end to write-----\n");
      ++$i;
    }

    return $this;
  }

  public function setReplacingText($text) {
    $this->replacingText = $text;

    return $this;
  }

  public function setReplacedText($text) {
    $this->replacedText = $text;

    return $this;
  }
 
}

?>
