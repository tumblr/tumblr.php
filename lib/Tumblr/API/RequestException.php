<?php

namespace Tumblr\API;

class RequestException extends \Exception
{
    public function __construct($response)
    {
        $error = $response->json;
        $errstr = isset($error->meta) ? $error->meta->msg : 'Unknown Error';

        $this->statusCode = $response->status;
        $this->message = $errstr;
        parent::__construct($this->message, $this->statusCode);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
