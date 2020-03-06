<?php

namespace Tumblr\API\NPF\Content;

abstract class ContentBlock {
    /**
     * @var string
     */
    protected $type;

    protected function __construct(string $type) {
        $this->type = $type;
    }

    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function toJSON() {
        return \get_object_vars($this);
    }
}