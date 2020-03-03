<?php

namespace Tumblr\API\NPF\Content;

abstract class ContentBlock {
    protected string $type;

    protected function __construct($type) {
        $this->type = $type;
    }

    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
    }
}