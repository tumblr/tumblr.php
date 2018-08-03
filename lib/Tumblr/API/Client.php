<?php

namespace Tumblr\API;

/**
 * A client to access the Tumblr API
 */
class Client
{

    private $apiKey;
    private $is_oauth1;

    /**
     * Create a new Client
     *
     * @param array $credentials     credentials for oauth1 or oauth2
     * @param options
     * credentials contain:
     *      string consumerKey    the consumer key
     *      string consumerSecret the consumer secret
     *      string oauthToken     oauth token
     *      string secret         oauth token secret
     *      string oauth2Token    oauth2 access token
     */
    public function __construct($credentials, $options=[])
    {
        if (isset($credentials['consumerKey'])) {
            $consumerKey = $credentials['consumerKey'];
            $consumerSecret = isset($credentials['consumerSecret']) ? $credentials['consumerSecret'] : '';
            $oauthToken = isset($credentials['oauthToken']) ? $credentials['oauthToken'] : '';
            $secret = isset($credentials['secret']) ? $credentials['secret'] : '';

            $this->is_oauth1 = true;
            $this->requestHandler = new RequestHandler();
            $this->setConsumer($consumerKey, $consumerSecret);
            $this->setToken($oauthToken, $secret);
            echo ($oauthToken);
            echo ($secret);
        } elseif (isset($credentials['oauth2Token'])) {
            $this->is_oauth1 = false;
            $this->requestHandler = new RequestHandler2();
            $options['access_token'] = $credentials['oauth2Token'];
            $this->setToken(null, null, $options);
        }
    }

    /**
     * Set the consumer for this client
     *
     * @param string $consumerKey    the consumer key
     * @param string $consumerSecret the consumer secret
     */
    public function setConsumer($consumerKey, $consumerSecret)
    {
        $this->apiKey = $consumerKey;
        $this->requestHandler->setConsumer($consumerKey, $consumerSecret);
    }

    /**
     * Set the token for this client
     *
     * @param string $token  the oauth token
     * @param string $secret the oauth secret
     * @param array $options   An array of options. The `access_token` option is required.
     */
    public function setToken($token=null, $secret=null, $options=[])
    {
        if (isset($token) && isset($secret)) {
            $this->requestHandler->setToken($token, $secret);
        } else {
            $this->requestHandler->setToken($options);
        }
    }

    /**
     * Retrieve RequestHandler instance
     *
     * @return RequestHandler | RequestHandler2
     */
    public function getRequestHandler()
    {
        return $this->requestHandler;
    }

    /**
     * Get info on the authenticating user
     *
     * @return array the response array
     */
    public function getUserInfo()
    {
        return $this->getRequest('v2/user/info', null, false);
    }

    /**
     * Get user dashboard for the authenticating user
     *
     * @param  array $options the options for the call
     * @return array the response array
     */
    public function getDashboardPosts($options = null)
    {
        return $this->getRequest('v2/user/dashboard', $options, false);
    }

    /**
     * Get followings for the authenticating user
     *
     * @param  array $options the options for the call
     * @return array the response array
     */
    public function getFollowedBlogs($options = null)
    {
        return $this->getRequest('v2/user/following', $options, false);
    }

    /**
     * Get likes for the authenticating user
     *
     * @param  array $options the options for the call
     * @return array the response array
     */
    public function getLikedPosts($options = null)
    {
        return $this->getRequest('v2/user/likes', $options, false);
    }

    /**
     * Follow a blog
     *
     * @param  string $blogName the name of the blog to follow
     * @return array  the response array
     */
    public function follow($blogName)
    {
        $options = array('url' => $this->blogUrl($blogName));

        return $this->postRequest('v2/user/follow', $options, false);
    }

    /**
     * Unfollow a blog
     *
     * @param  string $blogName the name of the blog to follow
     * @return array  the response array
     */
    public function unfollow($blogName)
    {
        $options = array('url' => $this->blogUrl($blogName));

        return $this->postRequest('v2/user/unfollow', $options, false);
    }

    /**
     * Like a post
     *
     * @param int    $postId    the id of the post
     * @param string $reblogKey the reblog_key of the post
     *
     * @return array the response array
     */
    public function like($postId, $reblogKey)
    {
        $options = array('id' => $postId, 'reblog_key' => $reblogKey);

        return $this->postRequest('v2/user/like', $options, false);
    }

    /**
     * Unlike a post
     *
     * @param int    $postId    the id of the post
     * @param string $reblogKey the reblog_key of the post
     *
     * @return array the response array
     */
    public function unlike($postId, $reblogKey)
    {
        $options = array('id' => $postId, 'reblog_key' => $reblogKey);

        return $this->postRequest('v2/user/unlike', $options, false);
    }

    /**
     * Delete a post
     *
     * @param string $blogName  the name of the blog the post is on
     * @param int    $postId    the id of the post
     * @param string $reblogKey the reblog_key of the post
     *
     * @return array the response array
     */
    public function deletePost($blogName, $postId, $reblogKey)
    {
        $options = array('id' => $postId, 'reblog_key' => $reblogKey);
        $path = $this->blogPath($blogName, '/post/delete');

        return $this->postRequest($path, $options, false);
    }

    /**
     * Reblog a post
     *
     * @param string $blogName  the name of the blog
     * @param int    $postId    the id of the post
     * @param string $reblogKey the reblog key of the post
     * @param array  $options   the options for the call
     *
     * @return array the response array
     */
    public function reblogPost($blogName, $postId, $reblogKey, $options = null)
    {
        $params = array('id' => $postId, 'reblog_key' => $reblogKey);
        $params = array_merge($options ?: array(), $params);
        $path = $this->blogPath($blogName, '/post/reblog');

        return $this->postRequest($path, $params, false);
    }

    /**
     * Edit a post
     *
     * @param string $blogName the name of the blog
     * @param int    $postId   the id of the post to edit
     * @param array  $data     the data to save
     *
     * @return array the response array
     */
    public function editPost($blogName, $postId, $data)
    {
        $data['id'] = $postId;
        $path = $this->blogPath($blogName, '/post/edit');

        return $this->postRequest($path, $data, false);
    }

    /**
     * Create a post
     *
     * @param string $blogName the name of the blog
     * @param array  $data     the data to save
     *
     * @return array the response array
     */
    public function createPost($blogName, $data)
    {
        $path = $this->blogPath($blogName, '/post');

        return $this->postRequest($path, $data, false);
    }

    /**
     * Get tagged posts
     *
     * @param string $tag     the tag to look up
     * @param array  $options the options for the call
     *
     * @return array the response array
     */
    public function getTaggedPosts($tag, $options = null)
    {
        if (!$options) {
            $options = array();
        }
        $options['tag'] = $tag;

        $addApiKey = $this->is_oauth1 ? true : false;
        $this->getRequest('v2/tagged', $options, $addApiKey);
    }

    /**
     * Get information about a given blog
     *
     * @param  string $blogName the name of the blog to look up
     * @return array  the response array
     */
    public function getBlogInfo($blogName)
    {
        $path = $this->blogPath($blogName, '/info');

        $addApiKey = $this->is_oauth1 ? true : false;
        return $this->getRequest($path, null, $addApiKey);
    }

    /**
     * Get blog avatar URL
     *
     * @param string $blogName the nae of the blog to look up
     * @param int    $size     the size to retrieve
     *
     * @return string the avatar url
     */
    public function getBlogAvatar($blogName, $size = null)
    {
        $path = $this->blogPath($blogName, '/avatar');
        if ($size) {
            $path .= "/$size";
        }

        $addApiKey = $this->is_oauth1 ? true : false;
        return $this->getRedirect($path, null, $addApiKey);
    }

    /**
     * Get blog likes for a given blog
     *
     * @param string $blogName the name of the blog to look up
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getBlogLikes($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/likes');
        $addApiKey = $this->is_oauth1 ? true : false;
        return $this->getRequest($path, $options, $addApiKey);
    }

    /**
     * Get blog followers for a given blog
     *
     * @param string $blogName the name of the blog to look up
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getBlogFollowers($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/followers');

        return $this->getRequest($path, $options, false);
    }

    /**
     * Get posts for a given blog
     *
     * @param string $blogName the name of the blog
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getBlogPosts($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/posts');
        if ($options && isset($options['type'])) {
            $path .= '/' . $options['type'];
            unset($options['type']);
        }

        $addApiKey = $this->is_oauth1 ? true : false;
        return $this->getRequest($path, $options, $addApiKey);
    }

    /**
     * Get queue posts for a given blog
     *
     * @param string $blogName the name of the blog
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getQueuedPosts($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/posts/queue');

        return $this->getRequest($path, $options, false);
    }

    /**
     * Get draft posts for a given blog
     *
     * @param string $blogName the name of the blog
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getDraftPosts($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/posts/draft');

        return $this->getRequest($path, $options, false);
    }

    /**
     * Get submission posts for a given blog
     *
     * @param string $blogName the name of the blog
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getSubmissionPosts($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/posts/submission');

        return $this->getRequest($path, $options, false);
    }

    /**
     * Make a GET request to the given endpoint and return the response
     *
     * @param string $path      the path to call on
     * @param array  $options   the options to call with
     * @param bool   $addApiKey whether or not to add the api key
     *
     * @return array the response object (parsed)
     */
    public function getRequest($path, $options, $addApiKey)
    {
        $response = $this->makeRequest('GET', $path, $options, $addApiKey);

        return $this->parseResponse($response);
    }

    /**
     * Make a POST request to the given endpoint and return the response
     *
     * @param string $path      the path to call on
     * @param array  $options   the options to call with
     * @param bool   $addApiKey whether or not to add the api key
     *
     * @return array the response object (parsed)
     */
    public function postRequest($path, $options, $addApiKey)
    {
        if (isset($options['source']) && is_array($options['source'])) {
            $sources = $options['source'];
            unset($options['source']);
            foreach ($sources as $i => $source) {
                $options["source[$i]"] = $source;
            }
        }

        $response = $this->makeRequest('POST', $path, $options, $addApiKey);
        return $this->parseResponse($response);
    }

    /**
     * Parse a response and return an appropriate result
     *
     * @param  \stdClass $response the response from the server
     *
     * @throws RequestException
     * @return array  the response data
     */
    private function parseResponse($response)
    {
        $response->json = json_decode($response->body);
        if ($response->status < 400) {
            return $response->json->response;
        } else {
            throw new RequestException($response);
        }
    }

    /**
     * Make a GET request to the given endpoint and return the response
     *
     * @param string $path      the path to call on
     * @param array  $options   the options to call with
     * @param bool   $addApiKey whether or not to add the api key
     *
     * @return string url redirected to (or null)
     */
    private function getRedirect($path, $options, $addApiKey)
    {
        $response = $this->makeRequest('GET', $path, $options, $addApiKey);
        if ($response->status === 301 || $response->status === 302) {
            return $response->headers['Location'][0];
        }

        return null;
    }

    /**
     * Make a request to the given endpoint and return the response
     *
     * @param string $method    the method to call: GET, POST
     * @param string $path      the path to call on
     * @param array  $options   the options to call with
     * @param bool   $addApiKey whether or not to add the api key
     *
     * @return \stdClass the response object (not parsed)
     */
    private function makeRequest($method, $path, $options, $addApiKey)
    {
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
     *
     * @param string $blogName the name of the blog
     * @param string $ext      the url extension
     *
     * @return string the blog base path
     */
    private function blogPath($blogName, $ext)
    {
        $blogUrl = $this->blogUrl($blogName);

        return "v2/blog/$blogUrl$ext";
    }

    /**
     * Get the URL of a blog by name or URL
     *
     * @param  string $blogName the name of the blog
     * @return string the blog URL
     */
    private function blogUrl($blogName)
    {
        if (strpos($blogName, '.') === false) {
            return "$blogName.tumblr.com";
        }

        return $blogName;
    }

}
