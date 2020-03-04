<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;

class LinkAttribution extends AttributionObject{
    use Tumblr\API\NPF\Content\ValidURL;

    protected string $url;

    public function __construct(string $url) {
        parent::__construct(AttributionTypes.Link);
        $this->url = validURL($url);
    }
}