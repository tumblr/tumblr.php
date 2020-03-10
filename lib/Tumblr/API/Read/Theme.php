<?php

namespace Tumblr\API\Read;

class Theme implements JsonSerializable {
    use \Tumblr\API\Read\ReadableTrait;
    /**
     * @var string;
     */
    protected $avatar_shape;
    /**
     * @var string
     */
    protected $background_color;
    /**
     * @var string
     */
    protected $body_font;
    /**
     * @var mixed
     */
    protected $header_bounds;
    /**
     * @var string
     */
    protected $header_image;
    /**
     * @var string
     */
    protected $header_image_poster;
    /**
     * @var string
     */
    protected $header_image_focused;
    /**
     * @var string
     */
    protected $header_image_scaled;
    /**
     * @var bool
     */
    protected $header_stretch;
    /**
     * @var string
     */
    protected $link_color;
    /**
     * @var bool
     */
    protected $show_avatar;
    /**
     * @var bool
     */
    protected $show_description;
    /**
     * @var bool
     */
    protected $show_header_image;
    /**
     * @var bool
     */
    protected $show_title;
    /**
     * @var string
     */
    protected $title_color;
    /**
     * @var string
     */
    protected $title_font;
    /**
     * @var string
     */
    protected $title_font_weight;


    /**
     * default c'tor
     */
    public function __construct(string $avatar_shape = '', string $background_color = '',
                                string $body_font = '', mixed $header_bounds = NULL, 
                                string $header_image = '', string $header_image_poster = '',
                                string $header_image_focused = '', string $header_image_scaled = '',
                                bool $header_stretch = false, string $link_color = '',
                                bool $show_avatar = true, bool $show_description = true,
                                bool $show_header_image = false, bool $show_title = true,
                                string $title_color = '', string $title_font = '',
                                string $title_font_weight = '') {
        $this->avatar_shape = $avatar_shape;
        $this->background_color = $background_color;
        $this->body_font = $body_font;
        $this->header_bounds = $header_bounds;
        $this->header_image = $header_image;
        $this->header_image_poster = $header_image_poster;
        $this->header_image_focused = $header_image_focused;
        $this->header_image_scaled = $header_image_scaled;
        $this->header_stretch = $header_stretch;
        $this->link_color = $link_color;
        $this->show_avatar = $show_avatar;
        $this->show_description = $show_description;
        $this->show_header_image = $show_header_image;
        $this->show_title = $show_title;
        $this->title_color = $title_color;
        $this->title_font = $title_font;
        $this->title_font_weight = $title_font_weight;
    }
}