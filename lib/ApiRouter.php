<?php

// @Auther Hwi Jun KIM. euler.bonjour@gmail.com
// See License.txt for license of this code.

require_once("lib/BaseRouter.php");
require_once("lib/TheWorld.php");
require_once("lib/KException.php");

class ApiRouter extends BaseRouter {

  public function __construct() {

  }

  public function exec($url) {
    // determine api, model, and filter
    // inject filter to a model.
    // call api with model
    // obtain result from model and return back it as json to client.

    try {
      $routingInfo = $this->parseUrl($url);
i
      // API Object
      $api = $routingInfo["api"];
      $model = $routingInfo["model"];
      $filter = $routinginfo["filter"];

      $model->injectFilter($filter);

      $apiResult = $api->call($model);

      $aJson =  Util::hashToJson($apiResult);
    }
    catch(KException $ex) {
      TheWorld::instance()->logger->log(Logger::WARN, $message);
      // Assume the result of getErrorMessage() is a hash.
      $errorJson = Util::hashTojson($this->getErrorMessage($api, $model, $filter, $ex));

      return $errorJson;
    }

    return $aJson;
  }

  // error code
  // error level
  // error message
  protected function getErrorMessage($api, $model, $filter, $ex) {
    $message = sprintf("ApiRouter::exec(): api call has been failed with the following api, model, and filter: %s %s %s %s", $api->toString(), $model->toString(), 
        $filter->toString(), $ex->getMessage());

    return $message;
  }

  // return val: hash. key: "api", "model", "filter"
  // structure of URL:
  // /version/api_name
  // argument should be passed by POST. As a REST, it should be passed by GET
  // for reference situation. However, as a design of API, I think it is better to use POST
  // considering how to construct URL event for & for modern /xxx/yyy URL structure.
  protected function parseUrl($url) {
    // debug
    throw new KException("ApiROuter::parseUrl(): this method has not been implemented yet.");
    // end of debug
  }

  protected function extractApiName($url) {
    // debug
    throw new Exception("ApiROuter::extractApiName(): this method has not been implemented yet.");
    // end of debug
  }

  // How about filter? There is secutiry issue if it were specified by URL.
  // I think it is better to map filter to model or controller by config files.
  // considering secutiry and how application by this framework is used => admin page.
  // Controllering filter by Url for consumer service application? It should not be happened.

  // Structure of config file. It is the CSV file.
  // api_name1,model_name1,filter_name1
  // api_name2,model_name2,filter_name2
  // it should be handled by an instance of Config class.
  // Or use Factory? I forgot, originally, to use Factory for filters.
  public function determineFilter($apiName, $model) {
    // debug
    throw new Exception("ApiRouter::determinFilter(): this method has not been implemented yet.");
    // end of debug
  }

}

?>