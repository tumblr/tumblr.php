<?php

namespace Tumblr\API\NPF\Read;

class PostFormat {
    protected string $object_type;
    protected string $type;
    protected string $id;
    protected string $tumblelog_uuid;
    protected string $reblog_key;
    protected array $trail;
    protected array $content;
    protected array $layout;

    protected function __construct(string $object_type, string $type, $id, string $tumblelog_uuid, 
                                 string $reblog_key, array $trail = [], array $content = [], array $layout = []){
        $this->object_type = $object_type;
        $this->type = $type;
        $this->id = $id;
        $this->tumblelog_uuid = $tumblelog_uuid;
        $this->reblog_key = $reblog_key;
        $this->trail = $trail;
        $this->content = $content;
        $this->layout = $layout;
    }

    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
    }
}