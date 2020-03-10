<?php

namespace Tumblr\API\Write;

use Tumblr\API\NPF\Write\NPFScheme;

class NPFReblogScheme extends NPFScheme {
    /**
     * @var string
     */
    protected $parent_tumblelog_uuid;
    /**
     * @var int
     */
    protected $parent_post_id;
    /**
     * @var string
     */
    protected $reblog_key;
    /**
     * @var bool
     */
    protected $hide_trail;

    public function  __construct($content, $layout= [], 
                        $state = NPFCreateState::Published,
                        $publish_on = NULL, 
                        $tags = NULL,
                        $source_url = NULL,
                        $send_to_twitter = false,
                        $send_to_facebook = false,
                        $parent_tumblelog_uuid,
                        $parent_post_id,
                        $reblog_key,
                        $hide_trail = false) {
        parent::construct($content, $layout, $state, $publish_on, 
                          $tags, $source_url, $send_to_twitter, $send_to_facebook);
        $this->parent_tumblelog_uuid = $parent_tumblelog_uuid;
        $this->parent_post_id = $parent_post_id;
        $this->reblog_key = $reblog_key;
       $this->hide_trail = $hide_trail;
    }

    public function toJSON(): string {
        return \json_encode(array_merge($this->toArray(), parent::toArray()));
    }

    protected function toArray() {
        return [
            "parent_tumblelog_uuid" => $this->parent_tumblelog_uuid,
            "parent_post_id" => $this->parent_post_id,
            "reblog_key" => $this->reblog_key,
            "hide_trail" => $this->hide_trail
        ];
    }
}