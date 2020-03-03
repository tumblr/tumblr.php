<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;

class ImageBlock extends ContentBlock {
    protected array $media;
    protected array $colors;
    protected string $feedback_token;
    protected MediaBlock $poster;
    protected AttributionObject $attribution;
    protected string $alt_text;

    public function __construct($media, $colors = [], $feedback_token = "", $poster = null, 
                                $attribution = null, $alt_text = "") {
        parent::__construct("image");
        $this->media = $media;
        $this->colors = $colors;
        $this->$feedback_token = $feedback_token;
        $this->post = $poster;
        $this->attribution = $attribution;
        $this->alt_text = $alt_text;
    }

}