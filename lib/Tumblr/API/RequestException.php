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
                if (is_array($error->response->errors) && count($error->response->errors)) {
                    $errstr .= ' ('.$error->response->errors[0].')';
                } else if (is_object($error->response->errors) && property_exists($error->response->errors, 'state')) {
                    $errstr .= ' ('.$error->response->errors->state.')';
                }                
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
