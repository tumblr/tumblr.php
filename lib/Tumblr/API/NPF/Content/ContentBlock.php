<?php

namespace Tumblr\API\NPF\Content;

abstract class ContentBlock {
    use \Tumblr\API\Read\ReadableTrait;
    /**
     * @var string
     */
    protected $type;

    protected function __construct(string $type) {
        $this->type = $type;
    }

    public function toJSON() {
        return \get_object_vars($this);
    }
}