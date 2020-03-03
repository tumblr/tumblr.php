<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\MediaBlock;
use Tumblr\API\NPF\Content\EmbedIFrameBlock;
use Tumblr\API\NPF\Exception\InvalidURLException;

class VideoBlock extends ContentBlock {
    use Tumblr\API\NPF\Content\ValidURL;
    
    protected string $url;
    protected MediaBlock $media;
    protected string $provider;
    protected MediaBlock $poster;
    protected string $embed_html;
    protected string $embed_url;
    protected EmbedIFrameBlock $embed_iframe;
    protected array $metadata;
    protected ArributionObject $attribution;
    protected boolean $can_autoplay_on_cellular;

    public function __construct(string $url = "", MediaBlock $media = null, string $provider = "",
                                 MediaBlock $poster = null, string $embed_html = "", string $embed_url = "",
                                 EmbedIFrameBlock $embed_iframe = null, object $metadata = null, 
                                 AttibutionObject $attribution = null, $can_autoplay_on_cellular = false) {
        parent::__construct("video");
        $this->url = validURL($url);
        $this->media = $media;
        $this->provider = $provider;
        $this->poster = $poster;
        $this->embed_html = $embed_html;
        $this->embeb_url = validURL($embed_url);
        $this->embed_iframe = $embed_iframe;
        $this->metadata = $metadata;
        $this->attribution = $attribution;
        $this->can_autoplay_on_cellular = $can_autoplay_on_cellular;
    }
}