<?php

namespace Tumblr\API\Read;

class PostFormat implements \JsonSerializable {
    use \Tumblr\API\Read\ReadableTrait;
    /**
     * @var string
     */
    protected $object_type;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $tumblelog_uuid;
    /**
     * @var string
     */
    protected $reblog_key;
    /**
     * @var array
     */
    protected $trail;
    /**
     * @var array
     */
    protected $content;
    /**
     * @var array
     */
    protected $layout;

    protected function __construct(string $object_type, string $type, $id, string $tumblelog_uuid, 
                                 string $reblog_key, ?array $trail = [], ?array $content = [], ?array $layout = []){
        $this->object_type = $object_type;
        $this->type = $type;
        $this->id = $id;
        $this->tumblelog_uuid = $tumblelog_uuid;
        $this->reblog_key = $reblog_key;
        $this->trail = $trail;
        $this->content = $content;
        $this->layout = $layout;
    }
}