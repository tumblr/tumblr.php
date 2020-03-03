<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;

class TextBlockSubtypes {
    public static function get() {
        return ["heading1",
            "heading2",
            "quirky",
            "quote",
            "indented",
            "chat",
            "ordered-list-item",
            "unordered-list-item"];
    }
}