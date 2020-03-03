<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;
use Tumblr\API\NPF\Content\MediaBlock;

class AppAttribution extends AttributionObject{
    use Tumblr\API\NPF\Content\ValidURL;

    protected string $url;
    protected string $app_name;
    protected string $display_text;
    protected MediaBlock $logo;

    public function __construct(string $url, string $app_name = "", string $display_text = "",
                                MediaBlock $logo = null) {
        parent::__construct(AttributionTypes.App);
        $this->url = validURL($url);
        $this->app_name = $app_name;
        $this->display_text = $display_text;
        $this->logo = $logo;
    }
}