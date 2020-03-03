<?php

namespace Tumblr\API\NPF\Write;

use Tumblr\API\NPF\Write\NPFCreateState;
use Tumblr\API\NPF\Exception\InvalidURLException;

class NPFScheme {
    protected string $id;
    protected Array $content;
    protected Array $layout;
    protected string $state;
    protected string $publish_on;
    protected string $tags;
    protected string $source_url;
    protected boolean $send_to_twitter;
    protected boolean $send_to_facebook;

    public function __construct($id = null, $content, $layout= [], 
        $state = NPFCreateState.Published,
        $publish_on = NULL, 
        $tags = NULL,
        $source_url = NULL,
        $send_to_twitter = false,
        $send_to_facebook = false) {
            $this->id = $id;
            $this->content = $content;
            $this->layout = $layout;
            $this->state = $state;
            $this->publish_on = ($publish_on === NULL? \date('l jS \of F Y h:i:s A') : $publish_on);
            $this->tags = $tags;
            $this->source_url = (\filter_var($source_url, FILTER_VALIDATE_URL) ? $source_url : NULL);
            $this->send_to_twitter = $send_to_twitter;
            $this->send_to_facebook = $send_to_facebook;
    }

    public function toJSON(): string {
        return \json_encode($this->toArray());
    }

    public function __get($property) {
        if(\property_exists($this, $property)) {
            return $this->$property;
        }
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
            "content" => $this->content,
            "layout" => $this->layout,
            "state" => $this->state,
            "publish_on" => $this->publish_on,
            "tags" => $this->tags,
            "source_url" => $this->source_url,
            "send_to_twitter" => $this->send_to_twitter,
            "send_to_facebook" => $this->send_to_facebook
        ];
    }
}