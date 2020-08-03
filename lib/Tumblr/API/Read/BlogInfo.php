<?php

namespace Tumblr\API\Read;

use Tumblr\API\Read\Theme;

class BlogInfo implements \JsonSerializable{
    use \Tumblr\API\Read\ReadableTrait;
    use \Tumblr\API\NPF\ValidationTrait;
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
    public function __construct(?string $name = '', ?string $title = '', ?string $description = '', ?string $url = "",
                                ?string $uuid = '', ?int $updated = 0, ?int $posts = 0,
                                ?bool $ask = false, ?bool $ask_anon = false, ?string $ask_page_title = '', ?int $likes = 0,
                                ?bool $followed = false, ?bool $is_blocked_from_primary = false, ?array $avatar = [],
                                ?Theme $theme = NULL, ?string $timezone_offset = '', ?bool $can_chat = false,
                                ?bool $can_send_fan_mail = false, ?bool $can_subscribe = false, ?bool $is_nsfw = false, 
                                ?bool $share_likes = false, ?string $submission_page_title = "", ?bool $subscribed = false, 
                                ?int $total_posts = 0, ?bool $is_optout_ads = false) {
        $this->title = $title;
        $this->posts = $posts;
        $this->name = $name;
        $this->updated = $updated;
        $this->description = $description;
        $this->ask = $ask;
        $this->ask_anon =  $ask_anon;
        $this->ask_page_title = $ask_page_title;
        $this->likes = $likes;
        $this->followed = $followed;
        $this->is_blocked_from_primary = $is_blocked_from_primary;
        $this->avatar = $avatar;
        $this->theme = $theme;
        $this->timezone_offset = $timezone_offset;
        $this->can_chat = $can_chat;
        $this->can_send_fan_mail = $can_send_fan_mail;
        $this->can_subscribe = $can_subscribe;
        $this->is_nsfw = $is_nsfw;
        $this->share_likes = $share_likes;
        $this->submission_page_title = $submission_page_title;
        $this->subscribed = $subscribed;
        $this->total_posts = $total_posts;
        $this->url = self::validURL($url);
        $this->uuid = $uuid;
        $this->is_optout_ads = $is_optout_ads;
    }
}