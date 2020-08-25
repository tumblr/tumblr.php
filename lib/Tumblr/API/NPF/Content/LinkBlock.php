<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class LinkBlock extends ContentBlock {
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $author;
    /**
     * @var string
     */
    protected $site_name;
    /**
     * @var string
     */
    protected $display_url;
    /**
     * @var \Tumblr\API\NPF\Content\MediaBlock|null
     */
    protected $poster;

    public function __construct($url, $title = "", $description = "", $author = "",
                                $site_name = "", $display_url = "", $poster = null) {
        parent::__construct("link");
        $this->url = $this->validURL($url);
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->site_name = $site_name;
        $this->display_url = $display_url;
        $this->poster = $poster;
    }

    protected function validURL($url) {
        if(\filter_var($source_url, FILTER_VALIDATE_URL))
            return $url;
        else 
            throw new InvalidURLException($url . " is not a valid URL");
    }
}