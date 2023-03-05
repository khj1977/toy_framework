<?php

require_once("lib/BaseApi.php");

class RESTApi extends BaseApi {
    protected $baseUrl;

    public function __construct() {
        return $this;
    }

    public function setBaseUrl($url) {
        $this->baseUrl = $url;

        return $this;
    }

    public function call($args) {
        // debug
        // implement this method.
        // end of debug
    }
}

?>