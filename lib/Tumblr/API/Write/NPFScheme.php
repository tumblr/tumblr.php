<?php

namespace Tumblr\API\Write;

use Tumblr\API\Write\NPFCreateState;
use Tumblr\API\NPF\Exception\InvalidURLException;
use Tumblr\API\HashInitializable;

class NPFScheme extends HashInitializable {
    use \Tumblr\API\Read\ReadableTrait;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    protected $content;
    /**
     * @var array
     */
    protected $layout;
    /**
     * @var NPFCreateState
     */
    protected $state = NPFCreateState::Published;
    /**
     * @var string
     */
    protected $publish_on;
    /**
     * @var string
     */
    protected $tags;
    /**
     * @var string
     */
    protected $source_url;
    /**
     * @var bool
     */
    protected $send_to_twitter;
    /**
     * @var bool
     */
    protected $send_to_facebook;

    public function __construct(array $content, $args) {
            $this->content = $content;
            parent::__construct($args);
    }

    public function toJSON(): string {
        return \json_encode($this->toArray());
    }

    public function __set($property, $value) {
        if($property == "source_url") {
            if(\filter_var($property, FILTER_VALIDATE_URL))
                $this->$property = $value;
            else
                throw new InvalidURLException($value . " is not a valid URL");
        }else if (\property_exists($this, $property)) {
            $this->$property = $value;
        }
      
        return $this;
    }

    protected function toArray() {
        return [
            "content" => $this->serializeArrayOfObjects($this->content),
            "layout" => $this->layout,
            "state" => $this->state,
            "publish_on" => $this->publish_on,
            "tags" => $this->tags,
            "source_url" => $this->source_url,
            "send_to_twitter" => $this->send_to_twitter,
            "send_to_facebook" => $this->send_to_facebook
        ];
    }

    protected function serializeArrayOfObjects($array) {
        $data = [];
        foreach($array as $field) {
            array_push($data, $field->toJSON());
        }

        return $data;
    }
}