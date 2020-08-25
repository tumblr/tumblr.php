<?php

namespace Tumblr\API\Write;

use Tumblr\API\Write\NPFScheme;

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

    public function  __construct($content,
                        $parent_tumblelog_uuid,
                        $parent_post_id,
                        $reblog_key, $args) {
        parent::__construct($content,$args);
        $this->parent_tumblelog_uuid = $parent_tumblelog_uuid;
        $this->parent_post_id = $parent_post_id;
        $this->reblog_key = $reblog_key;
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