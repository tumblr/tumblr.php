<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;

class PostAttribution extends AttributionObject{
    use Tumblr\API\NPF\Content\ValidURL;

    protected string $url;
    protected object $post;
    protected object $blog;

    public function __construct(string $url, object $post, object $blog) {
        parent::__construct(AttributionTypes.Post);
        $this->url = validURL($url);
        $this->post = $post;
        $this->blog = $blog;
    }
}