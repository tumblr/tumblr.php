<?php

class TextBlockSerializationTest extends \PHPUnit\Framework\TestCase
{
    public function testSerializesValidModel() {
        $model = new \Tumblr\API\NPF\Content\TextBlock("Hello World");
        $result = $model->toJSON();
        $this->assertEquals($result['text'], "Hello World");
        $this->assertEquals($result['subtype'],  null);
        $this->assertEquals($result['formatting'], []);
    }
}
