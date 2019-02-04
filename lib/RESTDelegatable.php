<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseDelegatable.php");
require_once("lib/util/HttpClient.php");
require_onec("lib/Util.php");
require_once("lib/TheWorld.php");
require_once("lib/util/KLogger.php");

class RESTDelegatable extends BaseDelegatable {

  protected $httpClient;
  protected $url;

  public function __construct($url) {
    parent::__construct();

    $this->url = $url;
    $this->httpClient = new HttpClient();
  }

  public function __call($methodName, $args) {
    if ($this->httpClient === null) {
      throw new UException("RESTDelegatable::__call(): httpClient has not been specified yet.");
    }

    $result = $this->callMethod($methodName, $args);

    return $result;
  }

  protected function callMethod($methodName, $args) {
    // debug
    // $result = call_user_method_array($methodName, $this->impl, $args);
    // The above is the case for method call for the same process of a php.call_user_func
    // For this class, call some REST API and return val.
    // end of debug

    $actualUrl = sprintf("%s/%s/facade", $this->url, $this->methodName);
    $realArgs = Util::jsonEncode($args);

    try {
      $result = $this->httpClient->post($actualUrl, $realArgs);
    }
    catch(KException $e) {
      $logger = TheWorld::instance()->logger();
      $logger->log(KLogger::warn, "some thing bad with RESTDelegate::callMethod():" . $e->toString());
    }

    $result = Util::JSONDecode($result);

    return $result;
  }

}

?>