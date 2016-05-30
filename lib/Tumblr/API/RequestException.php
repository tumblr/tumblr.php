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

        $errstr = 'Unknown Error';
        if (isset($error->meta)) {
            $errstr = $error->meta->msg;
            if (isset($error->response->errors)) {
                // Response from tumblr api seems changed
                // Looks like it returns: $error->response->errors->one return a one instead of an array index
                // Should be checked with if (isset($error->response->errors) && isset($error->response->errors[0])) { above
                // This solutions allows to at least have errors visibility
                $errstr .= ' ('.var_export($error->response->errors,true).')';
            }
        } elseif (isset($error->response->errors)) {
            $errstr = $error->response->errors[0];
        }

        $this->statusCode = $response->status;
        $this->message = $errstr;
        parent::__construct($this->message, $this->statusCode);
    }

    public function __toString()
    {
        return __CLASS__ . ": [$this->statusCode]: $this->message\n";
    }

}
