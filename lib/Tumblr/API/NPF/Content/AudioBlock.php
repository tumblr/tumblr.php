<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class AudioBlock extends ContentBlock {
    use Tumblr\API\NPF\Content\ValidURL;
    
    protected string $url;
    protected MediaBlock $media;
    protected string $provider;
    protected string $title;
    protected string $artist;
    protected string $album;
    protected MediaBlock $poster;
    protected string $embed_html;
    protected string $embed_url;
    protected array $metadata;
    protected ArributionObject $attribution;

    public function __construct(string $url = "", MediaBlock $media = null, string $provider = "",
                                 string $title = "",string  $artist = "", string $album = "",
                                 MediaBlock $poster = null, string $embed_html = "", string $embed_url = "",
                                 object $metadata = null, AttibutionObject $attribution = null) {
        parent::__construct("audio");
        $this->url = validURL($url);
        $this->media = $media;
        $this->provider = $provider;
        $this->title = $title;
        $this->artist = $artist;
        $this->album =  $album;
        $this->poster = $poster;
        $this->embed_html = $embed_html;
        $this->embeb_url = validURL($embed_url);
        $this->metadata = $metadata;
        $this->attribution = $attribution;
    }
}