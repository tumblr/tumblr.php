<?php

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
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

     /**
     * @expectedException GuzzleHttp\Exception\ConnectException
     */
    public function testRequestThrowsErrorOnMalformedBaseUrl()
    {
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();
        $rh->setBaseUrl('this is a malformed URL!');

        $options = array('some kinda option');

        $rh->request('GET', 'foo', $options);

    }

    /**
     * @expectedException Tumblr\API\RequestException
     */
    public function testRequestThrowsOnBadResponse()
    {
        // Response stream
        $stream = fopen('php://memory','r+');
        fwrite($stream, '{"meta": {"status": 400, "msg": "Sadface."} }');
        rewind($stream);

        // Hook up response to all requests
        $response = (new GuzzleHttp\Psr7\Response)
            ->withStatus(400, 'Bad Request')
            ->withBody(new GuzzleHttp\Psr7\Stream($stream));

        $this->guzzle = $this->getMock('\GuzzleHttp\Client', array('request'));
        $this->guzzle->expects($this->any())
                     ->method('request')
                     ->will($this->returnValue($response));

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();
        $rh->client = $this->guzzle;

        // Throws because it got a 400 back
        $client->getBlogInfo('ceyko.tumblr.com');
    }

    public function testRequestGetsJsonResponseField()
    {
        // Response stream
        $stream = fopen('php://memory','r+');
        fwrite($stream, '{"meta": {"status": 200, "msg": "OK"}, "response": "Response Text"}');
        rewind($stream);

        // Hook up response to all requests
        $response = (new GuzzleHttp\Psr7\Response)
            ->withStatus(200, 'OK')
            ->withBody(new GuzzleHttp\Psr7\Stream($stream));

        $this->guzzle = $this->getMock('\GuzzleHttp\Client', array('request'));
        $this->guzzle->expects($this->any())
                     ->method('request')
                     ->will($this->returnValue($response));

        // Attached mocked guzzle client
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();
        $rh->client = $this->guzzle;

        // Parses out the `reponse` field in json on success
        $this->assertEquals($client->getBlogInfo('ceyko.tumblr.com'), 'Response Text');
    }

}
