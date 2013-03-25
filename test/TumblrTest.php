<?php

class TumblrTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerCalls
     */
    public function testCalls($callable, $type, $path, $params, $which_mock = 'perfect')
    {
        // a good response
        $response = $this->getResponseMock($which_mock);

        // Create request mock and set it to check for the proper response
        $request = $this->getMock('Tumblr\API\RequestHandler', array('request'));
        $request->expects($this->once())
            ->method('request')
            ->with($this->equalTo($type), $this->equalTo($path), $this->equalTo($params))
            ->will($this->returnValue($response));

        // Create a new client and set it up to use that request handler
        $client = new Tumblr\API\Client(API_KEY);
        $ref = new ReflectionObject($client);
        $prop = $ref->getProperty('requestHandler');
        $prop->setAccessible(true);
        $prop->setValue($client, $request);

        // Give it tokens
        $client->setToken('t1', 't2');

        // And then run the callback to check the results
        $callable($client);
    }

    private function getResponseMock($which)
    {
        $response = new stdClass;
        if ($which == 'perfect') {
            $response->status = 200;
            $response->body = '{"response":[]}';
        } elseif ($which == 'redirect') {
            $response->status = 301;
            $response->headers = array('Location' => array('url'));
        } elseif ($which == 'not_found') {
            $response->status = 404;
            $response->body = '{}';
        }

        return $response;
    }

}
