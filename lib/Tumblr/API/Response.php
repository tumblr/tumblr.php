<?php

namespace Tumblr\API;

class Response {
    use \Tumblr\API\Read\ReadableTrait;
    /**
     * @var array
     * Meta information like status code
     * and status information as string.
     * If errors occured, this element will also contain information
     * about the occurring arrays.
     */
    protected $meta;
    /**
     * @var array
     * Response payload.
     * The content of this field may vary, depending on the action
     * this response instance has as origin.
     */
    protected $response;
    /**
     * @var array
     * Error load
     * This array contains objects of the type error.
     * If the Request was successful, this fiel will not exist.
     */
    protected $error;

    public function __construct(array $meta = [], array $response = [], ?array $errors = []) {
        $this->meta = $meta;
        $this->response = $response;
        $this->errors = $errors;
    }
}