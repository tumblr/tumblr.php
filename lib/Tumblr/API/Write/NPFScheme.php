<?php

namespace Tumblr\API\Write;

use Tumblr\API\Write\NPFCreateState;
use Tumblr\API\NPF\Exception\InvalidURLException;

class NPFScheme {
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
     * @var string
     */
    protected $state;
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

    public function __construct($id = '', array $content, array $layout= [], 
        string $state = NPFCreateState::Published,
        string $publish_on = '', 
        string $tags = '',
        string $source_url = '',
        bool $send_to_twitter = false,
        bool $send_to_facebook = false) {
            $this->id = $id;
            $this->content = $content;
            $this->layout = $layout;
            $this->state = $state;
            $this->publish_on = ($publish_on === NULL? \date('l jS \of F Y h:i:s A') : $publish_on);
            $this->tags = $tags;
            $this->source_url = (\filter_var($source_url, FILTER_VALIDATE_URL) ? $source_url : "");
            $this->send_to_twitter = $send_to_twitter;
            $this->send_to_facebook = $send_to_facebook;
    }

    public function toJSON(): string {
        return \json_encode($this->toArray());
    }

    public function __set($property, $value) {
        if($property == "source_url") {
            if(\filter_var($source_url, FILTER_VALIDATE_URL))
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