<?php

namespace Tumblr\API\NPF\Content\Attribution;

use Tumblr\API\NPF\Content\Attribution\AttributionObject;
use Tumblr\API\NPF\Content\Attribution\AttributionTypes;
use Tumblr\API\NPF\Content\MediaBlock;

/**
 * Class AppAttribution
 * @package Tumblr\API\NPF\Content\Attribution
 */
class AppAttribution extends AttributionObject{
    use Tumblr\API\NPF\Content\ValidationTrait;

    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $app_name;
    /**
     * @var string
     */
    protected $display_text;
    /**
     * @var MediaBlock
     */
    protected $logo;

    /**
     * AppAttribution constructor.
     * @param string $url URL to the Application Endpoint used for this type of attribution
     * @param string $app_name Name of the connected app as a canonical string
     * @param string $display_text Text to display when incorporating the attribution
     * @param MediaBlock|null $logo Application logo to display with the attributed content
     */
    public function __construct(string $url, string $app_name = "", string $display_text = "",
                                MediaBlock $logo = null) {
        parent::__construct(AttributionTypes.App);
        $this->url = validURL($url);
        $this->app_name = $app_name;
        $this->display_text = $display_text;
        $this->logo = $logo;
    }
}