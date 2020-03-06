<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;

class ImageBlock extends ContentBlock {
    /**
     * @var array
     */
    protected $media;
    /**
     * @var array
     */
    protected $colors;
    /**
     * @var string
     */
    protected $feedback_token;
    /**
     * @var \Tumblr\API\NPF\Content\MediaBlock|null
     */
    protected $poster;
    /**
     * @var AttributionObject|null
     */
    protected $attribution;
    /**
     * @var string
     */
    protected $alt_text;

    public function __construct($media, $colors = [], $feedback_token = "", $poster = null, 
                                $attribution = null, $alt_text = "") {
        parent::__construct("image");
        $this->media = $media;
        $this->colors = $colors;
        $this->feedback_token = $feedback_token;
        $this->poster = $poster;
        $this->attribution = $attribution;
        $this->alt_text = $alt_text;
    }

}