<?php

class RequestExceptionTest extends PHPUnit_Framework_TestCase
{
    public function provider()
    {
        $class_name = 'Tumblr\API\RequestException';

        return array(

            array(array('status' => 401, 'body' => '{}'), "$class_name: [401]: Unknown Error\n"),

            array(array('status' => 404, 'body' => '{"meta":{"msg":"cool story bro"}}'), "$class_name: [404]: cool story bro\n"),

        );
    }

    /**
     * @dataProvider provider
     */
    public function testErrorString($responseArr, $expectedString)
    {
        $response = (object) $responseArr;
        $err = new \Tumblr\API\RequestException($response);
        $this->assertEquals((string) $err, $expectedString);
    }

}
