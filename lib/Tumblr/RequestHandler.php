<?php

namespace Tumblr;

require 'vendor/autoload.php';

/**
 * A request handler for Tumblr authentication
 */
class RequestHandler
{

    private $consumer;
    private $token;
    private $signatureMethod;

    public function __construct()
    {
        $this->signatureMethod = new \Eher\OAuth\HmacSha1();
    }

    public function setConsumer($key, $secret)
    {
        $this->consumer = new \Eher\OAuth\Consumer($key, $secret);
    }

    public function setToken($token, $secret) {
        $this->token = new \Eher\OAuth\Token($token, $secret);
    }

    // TODO POST
    public function request($method, $path, $options)
    {

        $url = "http://api.tumblr.com/$path";
        $oauth = new \Eher\OAuth\Request($method, $url, $options);
        $oauth->sign_request($this->signatureMethod, $this->consumer, $this->token);

        $authHeader = $oauth->to_header();
        $pieces = explode(' ', $authHeader, 2);
        $authString = $pieces[1];

        $client = new \Guzzle\Http\Client($url);
        $request = $client->get();
        $request->addHeader('Authorization', $authString);
        $request->getQuery()->merge($options);

        try {
            $response = $request->send();
        } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            $response = $request->getResponse();
        }

        $obj = new \stdClass;
        $obj->status = $response->getStatusCode();
        $obj->body = $response->getBody();
        $obj->headers = $response->getHeaders();
        return $obj;

    }

}
