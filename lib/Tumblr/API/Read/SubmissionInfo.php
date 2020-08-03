<?php

namespace Tumblr\API\Read;

class SubmissionInfo {
    /**
     * @var array
     */
    protected $accepted_types;
    /**
     * @var array
     */
    protected $tags;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $guidelines;

    public function __construct(?array $accepted_types = [], ?array $tags = [],
                                ?string $title = '', ?string $guidelines = '') {
        $this->accepted_types = $accepted_types;
        $this->tags = $tags;
        $this->title = $title;
        $this->guidelines = $guidelines;
    }
}