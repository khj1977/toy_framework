<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once(dirname(__FILE__) . "/../lib/BaseBatch.php");
require_once("lib/RSSOutputHandler.php");
require_once("lib/RSSErrorHandler.php");
require_once("lib/RSSesConverter.php");
require_once("lib/RSS.php");

class RSSesConveterBatch extends BaseBatch {

  public function xmain($args) {
    mb_internal_encoding("UTF-8");

    $replacing = $args[1];
    $replaced = $args[2];

    /*
    set_error_handler(function($errorNo, $errorStr) {
        // debug
        return;
        // end of debug
        $message = sprintf("TheWorld::setErrorHandler(): %d\t%s", $errorNo, $errorStr);
        throw new Exception($message);
      } );
    // end of debug
    */

    $path = Util::realpath(dirname(__FILE__) . "/../input_files/foo.xml");
    $rss = new RSS();
    $rss->load($path);

    $rssOutputHandler = new RSSOutputHandler();
    // assume there is multiple item of rss.
    $converter = new RSSesConverter();
    $converter->setReplacingText($replacing);
    $converter->setReplacedText($replaced);
    $converter->setOutputHandler($rssOutputHandler);
    $converter->convert($rss);

  }

}

if ($argc != 3) {
  print("usage: prog replacing_string, replaced_string\n");
  exit;
}

$app = new RSSesConveterBatch();
$app->run($argv);

?>
