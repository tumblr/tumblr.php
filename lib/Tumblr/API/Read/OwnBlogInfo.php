<?php

namespace Tumblr\API\Read;

class OwnBlogInfo extends  \Tumblr\API\Read\BlogInfo {
    /**
     * @var bool
     */
    protected $admin;
    /**
     * @var bool
     */
    protected $can_submit;
    /**
     * @var int
     */
    protected $drafts;
    /**
     * @var char
     */
    protected $facebook;
    /**
     * @var char
     */
    protected $facebook_opengraph_enabled;
    /**
     * @var int
     */
    protected $followers;
    /**
     * @var int
     */
    protected $messages;
    /**
     * @var bool
     */
    protected $primary;
    /**
     * @var int
     */
    protected $queue;
    /**
     * @var SubmissionInfo
     */
    protected $submission_terms;
    /**
     * @var char
     */
    protected $tweet;
    /**
     * @var bool
     */
    protected $twitter_enabled;
    /**
     * @var bool
     */
    protected $twitter_send;
    /**
     * @var string
     */
    protected $type;

    public function __construct() {
        throw new Exception("Not implemented");
    }
}