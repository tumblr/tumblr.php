<?php

namespace Tumblr\API\Read;

use Tumblr\API\Read\Theme;
use Tumblr\API\HashInitializable;

class BlogInfo extends HashInitializable implements \JsonSerializable{
    use \Tumblr\API\Read\ReadableTrait;
    use \Tumblr\API\NPF\Content\ValidationTrait;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var int
     */
    protected $posts;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $updated;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var bool
     */
    protected $ask;
    /**
     * @var bool
     */
    protected $ask_anon;
    /**
     * @var string
     */
    protected $ask_page_title;
    /**
     * @var int
     */
    protected $likes;
    /**
     * @var bool
     */
    protected $followed;
    /**
     * @var bool
     */
    protected $is_blocked_from_primary;
    /**
     * @var array
     */
    protected $avatar;
    /**
     * @var Theme
     */
    protected $theme;
    /**
     * @var string
     */
    protected $timezone_offset;
    /**
     * @var bool
     */
    protected $can_chat;
    /**
     * @var bool
     */
    protected $can_send_fan_mail;
    /**
     * @var bool
     */
    protected $can_subscribe;
    /**
     * @var bool
     */
    protected $is_nsfw;
    /**
     * @var bool
     */
    protected $share_likes;
    /**
     * @var string
     */
    protected $submission_page_title;
    /**
     * @var bool
     */
    protected $subscribed;
    /**
     * @var int
     */
    protected $total_posts;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var bool
     */
    protected $is_optout_ads;

    /**
     * c'tor
     * @param string $title Title of the blog
     * @param int $posts Number of posts
     * @param string $name Name of the blog
     * @param int $updated Time in miliseconds since last update
     * @param string $description Description of the blog
     * @param bool $ask Status if blog allows questions
     * @param bool $ask_anon Status if blog allows anonymous questions
     * @param string $ask_page_title Title of the ask page
     * @param int $likes Number of likes this blog has created
     * @param bool $followed Indicates if teh currently authenticated user follows this account
     * @param bool $is_blocked_from_primary Status if this blog is being blocked by primary activated account
     * @param array $avatar Array with image objects of the avatars history
     * @param Theme $theme Theme object with information of the theme used by the blog
     * @param string $timezone_offset Offset from UTC time
     * @param bool $can_chat Status indicates if user is ready to chat
     * @param bool $can_send_fan_mail Status indicates if blog can send fan mail
     * @param bool $can_subscribe Status indicates wether the current blog can subscribe to the called blog
     * @param bool $is_nsfw Status indicates wether the blog has been flagged as NSFW
     * @param bool $share_likes Status indicates wether the blog shares its likes with the calling users or not
     * @param string $submission_page_title Title of the post submission page as string
     * @param bool $subscribed Status if subscribed
     * @param int $total_posts Number of all posts on this blog
     * @param string $url URL of this blog, follows the pattern https://{name}.tumblr.com
     * @param string $uuid UUID of the blog
     * @param bool $is_optout_ads Status if this blog is optout of ads
     */
    public function __construct($args) {
        parent::__construct($args);
    }
}