<?php

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $headers = PHPUnit_Framework_TestCase::createMock('Guzzle\Http\Message\Header\HeaderCollection',
                                  array('toArray'),
                                  array());

        $headers->expects($this->any())
                ->method('toArray')
                ->will($this->returnValue(array()));

        $response = PHPUnit_Framework_TestCase::createMock('Guzzle\Http\Message\Response',
                                   array('getStatusCode'),
                                   array(200, $headers));

        $response->expects($this->any())
                 ->method('getHeaders')
                 ->will($this->returnValue($headers));

        $request = PHPUnit_Framework_TestCase::createMock('Guzzle\Http\Message\EntityEnclosingRequest',
                                  array('send', 'getResponse', 'addPostFiles'),
                                  array('post', 'foo'));
        $request->expects($this->any())
                ->method('send')
                ->will($this->throwException(new \Guzzle\Http\Exception\BadResponseException));
        $request->expects($this->any())
                ->method('getResponse')
                ->will($this->returnValue($response));

        $this->guzzle = PHPUnit_Framework_TestCase::createMock('\Guzzle\Http\Client', array('post'));
        $this->guzzle->expects($this->any())
                     ->method('post')
                     ->will($this->returnValue($request));
    }

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
     * @expectedException Guzzle\Http\Exception\CurlException
     */
    public function testRequestThrowsErrorOnMalformedBaseUrl()
    {
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();
        $rh->setBaseUrl('this is a malformed URL!');

        $options = array('some kinda option');

        $rh->request('GET', 'foo', $options);

    }

    public function testRequestPost()
    {
        $client = new Tumblr\API\Client(API_KEY);
        $rh = $client->getRequestHandler();

        $rh->client = $this->guzzle;

        $rh->setBaseUrl('/');

        // Test with one file
        $options = array('data' => 'fake data');
        $rh->request('POST', 'meh', $options);

        // Test with array of files
        $options = array('data' => array('foo', 'bar'));
        $rh->request('POST', 'meh', $options);
    }

}
