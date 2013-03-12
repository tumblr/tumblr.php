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
        $this->client = new \Guzzle\Http\Client(null, array(
            'redirect.disable' => true
        ));
    }

    public function setConsumer($key, $secret)
    {
        $this->consumer = new \Eher\OAuth\Consumer($key, $secret);
    }

    public function setToken($token, $secret) {
        $this->token = new \Eher\OAuth\Token($token, $secret);
    }

    public function request($method, $path, $options)
    {

        $file = isset($options['data']) ? $options['data'] : false;
        unset($options['data']);

        $url = "http://api.tumblr.com/$path";
        $oauth = \Eher\OAuth\Request::from_consumer_and_token(
            $this->consumer, $this->token,
            $method, $url, $options
        );
        $oauth->sign_request($this->signatureMethod, $this->consumer, $this->token);

        $authHeader = $oauth->to_header();
        $pieces = explode(' ', $authHeader, 2);
        $authString = $pieces[1];

        if ($method === 'GET') {
            $request = $this->client->get($url, null);
            $request->addHeader('Authorization', $authString);
            $request->getQuery()->merge($options);
        } else {
            $request = $this->client->post($url, null, $options);
            $request->addHeader('Authorization', $authString);
            if ($file) {
                $request->addPostFiles(array('data' => $file));
            }
        }

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
