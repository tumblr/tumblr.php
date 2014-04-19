<?php

class RequestHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testBaseUrlHasTrailingSlash()
    {
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();
        $this->assertInstanceOf('Tumblr\API\RequestHandler', $rh);

        $rh->setBaseUrl('http://example.com');
        $this->assertAttributeEquals('http://example.com/', 'baseUrl', $rh);

        $rh->setBaseUrl('http://example.com/');
        $this->assertAttributeEquals('http://example.com/', 'baseUrl', $rh);
    }

}
