<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class MediaBlock extends ContentBlock {
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
    /**
     * @var bool
     */
    protected $original_dimensions_missing;
    /**
     * @var bool
     */
    protected $cropped;
    /**
     * @var bool
     */
    protected $has_original_dimensions;

    public function __construct($url, $type = "", $width = 540, $height = 405,
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