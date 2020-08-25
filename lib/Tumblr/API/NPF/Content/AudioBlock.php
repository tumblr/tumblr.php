<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;
use Tumblr\API\NPF\Content\ValidationTrait;

class AudioBlock extends ContentBlock {
    use ValidationTrait;

    /**
     * @var string
     */
    protected $url;
    /**
     * @var \Tumblr\API\NPF\Content\MediaBlock
     */
    protected $media;
    /**
     * @var string
     */
    protected $provider;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $artist;
    /**
     * @var string
     */
    protected $album;
    /**
     * @var \Tumblr\API\NPF\Content\MediaBlock
     */
    protected $poster;
    /**
     * @var string
     */
    protected $embed_html;
    /**
     * @var string
     */
    protected $embed_url;
    /**
     * @var array|object
     */
    protected $metadata;
    /**
     * @var ArributionObject|AttibutionObject
     */
    protected $attribution;

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
        $this->embed_url = validURL($embed_url);
        $this->metadata = $metadata;
        $this->attribution = $attribution;
    }
}