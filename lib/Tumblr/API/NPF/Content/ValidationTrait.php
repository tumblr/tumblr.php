<?php

namespace Tumblr\API\NPF\Content;

trait ValidationTrait {
    function validURL(string $url) {
        if(\filter_var($url, FILTER_VALIDATE_URL) || $url === "")
            return $url;
        else 
            throw new InvalidURLException($url . " is not a valid URL");
    }
}