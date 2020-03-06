<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;

class PostAttribution extends AttributionObject{
    use Tumblr\API\NPF\Content\ValidationTrait;

    /**
     * @var string
     */
    protected $url;
    /**
     * @var object
     */
    protected $post;
    /**
     * @var object
     */
    protected $blog;

    public function __construct(string $url, object $post, object $blog) {
        parent::__construct(AttributionTypes.Post);
        $this->url = validURL($url);
        $this->post = $post;
        $this->blog = $blog;
    }
}