<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class EmbedIFrameBlock extends ContentBlock {
    /**
     * @var string
     */
    protected $url;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var int
     */
    protected $height;

    public function __construct($url, string $type = "", $width = 540, $height = 405) {
        parent::__construct($type);
        if(\filter_var($url, FILTER_VALIDATE_URL))
            $this->url = $url;
        else 
            throw new InvalidURLException($url . " is not a valid URL");
        $this->width = $width;
        $this->height = $height;
    }
}