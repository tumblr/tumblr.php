<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionType;

abstract class AttributionObject {
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