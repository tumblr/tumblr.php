<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;

class BlogAttribution extends AttributionObject{
    protected object $blog;

    public function __construct(object $blog) {
        parent::__construct(AttributionTypes.Blog);
        $this->blog = $blog;
    }
}