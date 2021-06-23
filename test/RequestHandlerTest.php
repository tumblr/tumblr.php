<?php

class RequestHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testBaseUrlHasTrailingSlash()
    {
        $client = new Tumblr\API\Client(['consumerKey' => API_KEY]);
        $rh = $client->getRequestHandler();
        $this->assertInstanceOf('Tumblr\API\RequestHandler', $rh);

        $rh->setBaseUrl('http://example.com');
        $this->assertAttributeEqualsCompat('http://example.com/', 'baseUrl', $rh);

        $rh->setBaseUrl('http://example.com/');
        $this->assertAttributeEqualsCompat('http://example.com/', 'baseUrl', $rh);
    }

    public function testRequestThrowsErrorOnMalformedBaseUrl()
    {
        $client = new Tumblr\API\Client(['consumerKey' => API_KEY]);
        $rh = $client->getRequestHandler();
        $rh->setBaseUrl('this is a malformed URL!');

        $options = array('some kinda option');

        $this->expectException(\GuzzleHttp\Exception\ConnectException::class);

        $rh->request('GET', 'foo', $options);
    }

    public function testRequestThrowsOnBadResponse()
    {
        // Setup mock handler and response
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(400, [], '{"meta": {"status": 400, "msg": "Sadface"} }'),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $guzzle = new GuzzleHttp\Client(['handler' => $stack]);

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(['consumerKey' => API_KEY]);
        $client->getRequestHandler()->client = $guzzle;

        $this->expectException(\Tumblr\API\RequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Sadface');

        // Throws because it got a 400 back
        $client->getBlogInfo('ceyko.tumblr.com');
    }

    public function testRequestGetsJsonResponseField()
    {
        // Setup mock handler and response
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], '{"meta": {"status": 200, "msg": "OK"}, "response": "Response Text"}'),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $guzzle = new GuzzleHttp\Client(['handler' => $stack]);

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(['consumerKey' => API_KEY]);
        $client->getRequestHandler()->client = $guzzle;

        // Parses out the `reponse` field in json on success
        $this->assertEquals($client->getBlogInfo('ceyko.tumblr.com'), 'Response Text');
    }

    // OAuth2 tests
    public function testBaseUrlHasTrailingSlash2()
    {
        $client = new Tumblr\API\Client(['oauth2Token' => ACCESS_TOKEN]);
        $rh = $client->getRequestHandler();
        $this->assertInstanceOf('Tumblr\API\RequestHandler2', $rh);

        $rh->setBaseUrl('http://example.com');
        $this->assertAttributeEquals('http://example.com/', 'baseUrl', $rh);

        $rh->setBaseUrl('http://example.com/');
        $this->assertAttributeEquals('http://example.com/', 'baseUrl', $rh);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ConnectException
     */
    public function testRequestThrowsErrorOnMalformedBaseUrl2()
    {
        $client = new Tumblr\API\Client(['oauth2Token' => ACCESS_TOKEN]);
        $rh = $client->getRequestHandler();
        $rh->setBaseUrl('this is a malformed URL!');

        $options = array('some kinda option');

        $rh->request('GET', 'foo', $options);

    }

    /**
     * @expectedException Tumblr\API\RequestException
     * @expectedExceptionCode 400
     * @expectedExceptionMessage Sadface
     */
    public function testRequestThrowsOnBadResponse2()
    {
        // Setup mock handler and response
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(400, [], '{"meta": {"status": 400, "msg": "Sadface"} }'),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $guzzle = new GuzzleHttp\Client(['handler' => $stack]);

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(['oauth2Token' => ACCESS_TOKEN]);
        $client->getRequestHandler()->client = $guzzle;

        // Throws because it got a 400 back
        $client->getBlogInfo('ceyko.tumblr.com');
    }

    public function testRequestGetsJsonResponseField2()
    {
        // Setup mock handler and response
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, [], '{"meta": {"status": 200, "msg": "OK"}, "response": "Response Text"}'),
        ]);
        $stack = GuzzleHttp\HandlerStack::create($mock);
        $guzzle = new GuzzleHttp\Client(['handler' => $stack]);

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(['oauth2Token' => ACCESS_TOKEN]);
        $client->getRequestHandler()->client = $guzzle;

        // Parses out the `response` field in json on success
        $this->assertEquals($client->getBlogInfo('ceyko.tumblr.com'), 'Response Text');
    }
      
    private function assertAttributeEqualsCompat($expected, $attribute, $object)
    {
        $reflectionProperty = new ReflectionProperty(get_class($object),$attribute);
        $reflectionProperty->setAccessible(true);

        $this->assertSame($expected, $reflectionProperty->getValue($object));
    }
}
