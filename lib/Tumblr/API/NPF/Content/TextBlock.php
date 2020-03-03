<?php

namespace Tumblr\API\NPF\Content;

use Tumblr\API\NPF\Content\ContentBlock;
use Tumblr\API\NPF\Content\TextBlockSubtypes;
use Tumblr\API\NPF\Exception\InvalidSubtypeException;

class TextBlock extends ContentBlock {
    protected string $text;
    protected string $subtype;
    protected array $formatting;

    public function __construct($text, $subtype = "", $formatting = []) {
        parent::__construct("text");
        $this->text = $text;
        $this->validSubtype($subtype);
        $this->subtype = $subtype;
        $this->formatting = $formatting;
    }

    protected function validSubtype($subtype) {
        if(!\in_array($subtype, TextBlockSubtypes::get()) && $subtype !== "") {
            throw new InvalidSubtypeException($subtype . "is not a valid subtype");
        }
    }
}