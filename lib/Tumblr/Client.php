<?php

namespace Tumblr;
require_once(__DIR__ . '/RequestHandler.php');

/**
 * A client to access the Tumblr API
 */
class Client {

    private $apiKey;

    /**
     * Create a new Client
     */
    public function __construct() {
        $this->requestHandler = new RequestHandler();
    }

    /**
     * Set the consumer for this client
     * @param $consumerKey [string] the consumer key
     * @param $consumerSecret [string] the consumer secret
     */
    public function setConsumer($consumerKey, $consumerSecret) {
        $this->apiKey = $consumerKey;
        $this->requestHandler->setConsumer($consumerKey, $consumerSecret);
    }

    /**
     * Get info on the authenticating user
     * @return [array] the response array
     */
    public function getUserInfo() {
        return $this->getRequest('v2/user/info', null, false);
    }

    /**
     * Get user dashboard for the authenticating user
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getDashboardPosts($options = null) {
        return $this->getRequest('v2/user/dashboard', $options, false);
    }

    /**
     * Get followings for the authenticating user
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getFollowedBlogs($options = null) {
        return $this->getRequest('v2/user/following', $options, false);
    }

    /**
     * Get likes for the authenticating user
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
     public function getLikedPosts($options = null) {
        return $this->getRequest('v2/user/likes', $options, false);
     }

    /**
     * Follow a blog
     * @param @blogName the name of the blog to follow
     * @return [array] the response array
     */
    public function follow($blogName) {
        $options = array('url' => $this->blogUrl($blogName));
        return $this->postRequest('v2/user/follow', $options, false);
    }

    /**
     * Unfollow a blog
     * @param @blogName the name of the blog to follow
     * @return [array] the response array
     */
    public function unfollow($blogName) {
        $options = array('url' => $this->blogUrl($blogName));
        return $this->postRequest('v2/user/unfollow', $options, false);
    }

    /**
     * Get tagged posts
     * @param $tag [string] the tag to look up
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getTaggedPosts($tag, $options = null) {
        if (!$options) {
            $options = array();
        }
        $options['tag'] = $tag;
        return $this->getRequest('v2/tagged', $options, true);
    }

    /**
     * Get information about a given blog
     * @param $blogName [string] the name of the blog to look up
     * @return [array] the response array
     */
    public function getBlogInfo($blogName) {
        $path = $this->blogPath($blogName, '/info');
        return $this->getRequest($path, null, true);
    }

    /**
     * Get blog avatar URL
     * @param $blogName [string] the nae of the blog to look up
     * @param $size [int] the size to retrieve
     * @return [string] the avatar url
     */
    public function getBlogAvatar($blogName, $size = null) {
        $path = $this->blogPath($blogName, '/avatar');
        if ($size) {
            $path .= "/$size";
        }
        return $this->getRedirect($path, null, true);
    }

    /**
     * Get blog likes for a given blog
     * @param $blogName [string] the name of the blog to look up
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getBlogLikes($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/likes');
        return $this->getRequest($path, $options, true);
    }

    /**
     * Get blog followers for a given blog
     * @param $blogName [string] the name of the blog to look up
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getBlogFollowers($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/followers');
        return $this->getRequest($path, $options, false);
    }

    /**
     * Get posts for a given blog
     * @param $blogName [string] the name of the blog
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getBlogPosts($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/posts');
        if ($options && isset($options['type'])) {
            $path .= '/' . $options['type'];
            unset($options['type']);
        }
        return $this->getRequest($path, $options, true);
    }

    /**
     * Get queue posts for a given blog
     * @param $blogName [string] the name of the blog
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getQueuedPosts($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/posts/queue');
        return $this->getRequest($path, $options, false);
    }

    /**
     * Get draft posts for a given blog
     * @param $blogName [string] the name of the blog
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getDraftPosts($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/posts/draft');
        return $this->getRequest($path, $options, false);
    }

    /**
     * Get submission posts for a given blog
     * @param $blogName [string] the name of the blog
     * @param $options [array] the options for the call
     * @return [array] the response array
     */
    public function getSubmissionPosts($blogName, $options = null) {
        $path = $this->blogPath($blogName, '/posts/submission');
        return $this->getRequest($path, $options, false);
    }

    /*
     ************
     ************
     ************
     */

    /**
     * Make a GET request to the given endpoint and return the response
     * @param $path [string] the path to call on
     * @param $options [array] the options to call with
     * @param $addApiKey [boolean] whether or not to add the api key
     */
    private function getRequest($path, $options, $addApiKey) {
        $response = $this->makeRequest('GET', $path, $options, $addApiKey);
        return $this->parseResponse($response);
    }

    /**
     * Make a POST request to the given endpoint and return the response
     * @param $path [string] the path to call on
     * @param $options [array] the options to call with
     * @param $addApiKey [boolean] whether or not to add the api key
     */
    private function postRequest($path, $options, $addApiKey) {
        $response = $this->makeRequest('POST', $path, $options, $addApiKey);
        return $this->parseResponse($response);
    }

    /**
     * Parse a response and return an appropriate result
     * @param $response [Object] the response from the server
     * @return array the response data
     * @throws an error occurred
     */
    private function parseResponse($response) {
        if ($response->status < 400) {
            $data = json_decode($response->body);
            return $data->response;
        } else {
            $error = json_decode($response->body);
            $errstr = isset($data->meta) ? $data->meta->msg : 'Unknown Error';
            throw new Exception($errstr);
        }
    }

    /**
     * Make a GET request to the given endpoint and return the response
     * @param $path [string] the path to call on
     * @param $options [array] the options to call with
     * @param $addApiKey [boolean] whether or not to add the api key
     * @return [string] url redirected to (or null)
     */
    private function getRedirect($path, $options, $addApiKey) {
        $response = $this->makeRequest('GET', $path, $options, $addApiKey);
        if ($response->status === 301) {
            return $response->headers['Location'];
        }
        return null;
    }

    /**
     * Make a request to the given endpoint and return the response
     * @param $method [string] the method to call: GET, POST
     * @param $path [string] the path to call on
     * @param $options [array] the options to call with
     * @param $addApiKey [boolean] whether or not to add the api key
     */
    private function makeRequest($method, $path, $options, $addApiKey) {
        if ($addApiKey) {
            $options = array_merge(
                array('api_key' => $this->apiKey),
                $options ?: array()
            );
        }
        return $this->requestHandler->request($method, $path, $options);
    }

    /**
     * Expand the given blogName into a base path for the blog
     * @param $blogName [string] the name of the blog
     * @return [string] the blog base path
     */
    private function blogPath($blogName, $ext) {
        $blogUrl = $this->blogUrl($blogName);
        return "v2/$blogUrl$ext";
    }

    /**
     * Get the URL of a blog by name or URL
     * @param $blogName [string] the name of the blog
     * @return string the blog URL
     */
    private function blogUrl($blogName) {
        if (strpos($blogName, '.') === false) {
            return "$blogName.tumblr.com";
        }
        return $blogName;
    }

}
