<?php

namespace Tumblr\API\Read;

use Tumblr\API\Read\Theme;

class BlogInfo implements \JsonSerializable{
    use \Tumblr\API\Read\ReadableTrait;
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
     * @var int
     */
    protected $likes;
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
     * c'tor
     * @param string $title Title of the blog
     * @param int $posts Number of posts
     * @param string $name Name of the blog
     * @param int $updated Time in miliseconds since last update
     * @param string $description Description of the blog
     * @param bool $ask Status if blog allows questions
     * @param bool $ask_anon Status if blog allows anonymous questions
     * @param int $likes Number of likes this blog has created
     * @param bool $is_blocked_from_primary Status if this blog is being blocked by primary activated account
     * @param array $avatar Array with image objects of the avatars history
     * @param Theme $theme Theme object with information of the theme used by the blog
     * @param string $timezone_offset Offset from UTC time
     */
    public function __construct($title = '', $posts = 0, $name = '', $updated = 0, $description = '',
                                $ask = false, $ask_anon = false, $likes = 0, $is_blocked_from_primary = false, $avatar = [],
                                $theme = NULL, $timezone_offset = '') {
        $this->title = $title;
        $this->posts = $posts;
        $this->name = $name;
        $this->updated = $updated;
        $this->description = $description;
        $this->ask = $ask;
        $this->ask_anon =  $ask_anon;
        $this->likes = $likes;
        $this->is_blocked_from_primary = $is_blocked_from_primary;
        $this->avatar = $avatar;
        $this->theme = $theme;
        $this->timezone_offset = $timezone_offset;
    }
}