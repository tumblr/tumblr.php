<?php

namespace Tumblr\API\NPF\Write;

abstract class NPFCreateState {
    const Published = "published";
    const Queue = "queue";
    const Draft = "draft";
    const Private = "private";
}