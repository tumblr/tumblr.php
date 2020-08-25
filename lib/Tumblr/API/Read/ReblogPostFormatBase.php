<?php

namespace Tumblr\API\Read;

use Tumblr\API\NPF\Read\PostFormat;

class ReblogPostFormat extends PostFormat {
    /**
     * @var string
     */
    protected $parent_post_id;
    /**
     * @var string
     */
    protected $parent_tumblelog_uuid;

    protected function __construct(?string $object_type = "", string $type, $id, ?string $tumblelog_uuid = "", 
                                   string $reblog_key, ?array $trail = [], ?array $content = [], ?array $layout = [],
                                   ?string $parent_tumblelog_uuid = "", ?string $parent_post_id="") {
        parent::construct($object_type, $type, $id, $tumblelog_uuid, 
                          $reblog_key, $trail, $content, $layout);
        $this->parent_post_id = $parent_post_id;
        $this->parent_tumblelog_uuid = $parent_tumblelog_uuid;
    }
}