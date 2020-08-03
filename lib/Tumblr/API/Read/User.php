<?php

namespace Tumblr\API\Read;

class User implements JsonSerializable {
    use \Tumblr\API\Read\ReadableTrait;
    use \Tumblr\API\NPF\Content\ValidationTrait;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var int
     */
    protected $updated;
    /**
     * @var bool
     */
    protected $following;

    public function __construct(?string $name = '', ?string $url = '', ?int $updated = 0, ?bool $following = false) {
        $this->name = $name;
        $this->url = self::validURL($url);
        $this->updated = $updated;
        $this->following = $following;
    }
}