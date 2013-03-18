<?php

namespace Tumblr\API;

class RequestException extends \Exception
{

    /**
     * @param \stdClass $response
     */
    public function __construct($response)
    {
        $error = json_decode($response->body);
        $errstr = isset($error->meta) ? $error->meta->msg : 'Unknown Error';

        $this->statusCode = $response->status;
        $this->message = $errstr;
        parent::__construct($this->message, $this->statusCode);
    }

    public function __toString()
    {
        return __CLASS__ . ": [$this->statusCode]: $this->message\n";
    }

}
