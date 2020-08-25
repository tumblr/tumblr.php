<?php

namespace Tumblr\API\Read;

class User {
    use \Tumblr\API\Read\ReadableTrait;
    use \Tumblr\API\NPF\Content\ValidationTrait;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $likes;
    /**
     * @var string
     */
    protected $default_post_format;
    /**
     * @var bool
     */
    protected $following;

    /**
     * @var array
     */
    protected $blogs;    

    public function __construct(?string $name = '', ?int $likes = 0, ?string $default_post_format = '', ?int $following = 0, ?array $blogs) {
        $this->name = $name;
        $this->likes = $likes;
        $this->default_post_format = $default_post_format;
        $this->following = $following;
        $owned_blogs = [];
        #print_r($blogs);
        foreach($blogs as $blog) {
            array_push($owned_blogs, new OwnBlogInfo((array)$blog));
        }
        $this->blogs = $owned_blogs;
    }
}