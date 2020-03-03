<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class LinkBlock extends ContentBlock {
    protected string $url;
    protected string $title;
    protected string $description;
    protected string $author;
    protected string $site_name;
    protected string $display_url;
    protected MediaBlock $poster;

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