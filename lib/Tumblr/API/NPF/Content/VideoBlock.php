<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Content\EmbedIFrameBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class VideoBlock extends ContentBlock {
    use Tumblr\API\NPF\Content\ValidationTrait;

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
     * @var \Tumblr\API\NPF\Content\EmbedIFrameBlock
     */
    protected $embed_iframe;
    /**
     * @var array
     */
    protected $metadata;
    /**
     * @var AttributionObject
     */
    protected $attribution;
    /**
     * @var bool
     */
    protected $can_autoplay_on_cellular;

    public function __construct(string $url = "", MediaBlock $media = null, string $provider = "",
                                 MediaBlock $poster = null, string $embed_html = "", string $embed_url = "",
                                 EmbedIFrameBlock $embed_iframe = null, array $metadata = null,
                                 AttributionObject $attribution = null, $can_autoplay_on_cellular = false) {
        parent::__construct("video");
        $this->url = validURL($url);
        $this->media = $media;
        $this->provider = $provider;
        $this->poster = $poster;
        $this->embed_html = $embed_html;
        $this->embed_url = validURL($embed_url);
        $this->embed_iframe = $embed_iframe;
        $this->metadata = $metadata;
        $this->attribution = $attribution;
        $this->can_autoplay_on_cellular = $can_autoplay_on_cellular;
    }
}