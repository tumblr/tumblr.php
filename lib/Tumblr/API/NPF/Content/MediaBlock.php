<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class MediaBlock extends ContentBlock {
    protected string $url;
    protected int $width;
    protected int $height;
    protected boolean $original_dimensions_missing;
    protected boolean $cropped;
    protected boolean $has_original_dimensions;

    public function __construct($type = "", $url, $width = 540, $height = 405,
                                 $original_dimensions_missing = false,
                                 $cropped = false,
                                 $has_original_dimensions = false) {
        parent::__construct($type);
        if(\filter_var($source_url, FILTER_VALIDATE_URL))
            $this->url = $url;
        else 
            throw new InvalidURLException($url . " is not a valid URL");
        $this->width = $width;
        $this->height = $height;
        $this->original_dimensions_missing = $original_dimensions_missing;
        $this->cropped = $cropped;
        $this->has_original_dimensions = $has_original_dimensions;
    }
}