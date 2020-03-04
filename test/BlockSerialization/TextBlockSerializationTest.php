<?php

use Tumblr\API\NPF\Exception\InvalidSubtypeException;

class TextBlockSerializationTest extends \PHPUnit\Framework\TestCase
{
    public function testSerializesValidModel() {
        $model = new \Tumblr\API\NPF\Content\TextBlock("Hello World");
        $result = $model->toJSON();
        $this->assertEquals($result['text'], "Hello World");
        $this->assertEquals($result['subtype'],  null);
        $this->assertEquals($result['formatting'], []);
    }

    public function testAllowsOnlyValidSubType() {
        $model = new \Tumblr\API\NPF\Content\TextBlock("Hello World", "heading1");
        $data = $model->toJSON();
        $this->assertEquals("Hello World", $data['text']);
        $this->assertEquals("heading1", $data['subtype']);

        $this->expectException(InvalidSubtypeException::class);
        $model = new \Tumblr\API\NPF\Content\TextBlock("Hello World 2", "richard");
    }

    public function testSerializeFormattingObjects() {
        $model = new \Tumblr\API\NPF\Content\TextBlock("Hello World", "heading1",
            [(object)[
                "start" => 0,
                "end" => 3,
                "type" => "bold"
            ]]);
        $data = $model->toJSON();
        $this->assertEquals($data['formatting'], [(object)["start"=> 0, "end"=> 3, "type" =>"bold"]]);
    }
}
