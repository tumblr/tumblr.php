<?php
namespace Tumblr\API\Read;

trait ReadableTrait{
    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function jsonSerialize() {
        return \get_object_vars($this);
    }
}