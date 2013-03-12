<?php

namespace Tumblr;

/**
 * A request handler for Tumblr authentication
 */
class RequestHandler {

    private $consumerKey;
    private $consumerSecret;

    public function setConsumer($consumerKey, $consumerSecret) {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    public function request($method, $path, $options) {
        // TODO
    }

}
