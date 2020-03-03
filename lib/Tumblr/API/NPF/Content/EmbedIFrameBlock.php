<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class EmbedIFrameBlock extends ContentBlock {
    protected string $url;
    protected int $width;
    protected int $height;

    public function __construct($type = "", $url, $width = 540, $height = 405) {
        parent::__construct($type);
        if(\filter_var($source_url, FILTER_VALIDATE_URL))
            $this->url = $url;
        else 
            throw new InvalidURLException($url . " is not a valid URL");
        $this->width = $width;
        $this->height = $height;
    }
}