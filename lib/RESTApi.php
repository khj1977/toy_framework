<?php

require_once("lib/BaseApi.php");

// debug
// implement this class
// end of debug

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