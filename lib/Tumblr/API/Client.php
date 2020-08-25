<?php

namespace Tumblr\API;

use Tumblr\API\Write\NPFScheme;
use Tumblr\API\Write\NPFReblogScheme;
use Tumblr\API\Read\BlogInfo;
use Tumblr\API\RequestException;
use Tumblr\API\Read\User;
/**
 * A client to access the Tumblr API
 */
class Client
{
    /**
     * @var string
     * API Key for a registered user
     */
    private $apiKey;

    /**
     * Create a new Client
     *
     * @param string $consumerKey    the consumer key
     * @param string $consumerSecret the consumer secret
     * @param string $token          oauth token
     * @param string $secret         oauth token secret
     */
    public function __construct(string $consumerKey, string $consumerSecret = null, string $token = null, string $secret = null)
    {
        $this->requestHandler = new RequestHandler();
        $this->setConsumer($consumerKey, $consumerSecret);

        if ($token && $secret) {
             $this->setToken($token, $secret);
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
     */
    public function setToken($token, $secret)
    {
        $this->requestHandler->setToken($token, $secret);
    }

    /**
     * Retrieve RequestHandler instance
     *
     * @return RequestHandler
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
        $response = $this->getRequest('v2/user/info', null, false);
        return new User(
            $response->user->name,
            $response->user->likes,
            $response->user->default_post_format,
            $response->user->following,  
            $response->user->blogs
        );
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
     * @param int $postId the id of the post to edit
     * @param NPFScheme $data the data to save
     *
     * @return array the response array
     */
    public function editPost($blogName, $postId, NPFScheme $data)
    {
        $data->id = $postId;
        $path = $this->blogPath($blogName, '/posts/'.$postId);
        return $this->postRequest($path, $data->toJSON(), false);
    }

    /**
     * @param $blogName the name of the blog
     * @param $postId the id of the post to edit
     * @param $data the data to save
     *
     * @return array the response array
     */
    public function editLegacyPost($blogName, $postId, $data) {
        $data['id'] = $postId;
        $path = $this->blogPath($blogName, '/post/edit');
        return $this->postRequest($path, $data, false);
    }

    /**
     * Create a post
     *
     * @param string $blogName the name of the blog
     * @param NPFScheme $data the data to save
     *
     * @return array the response array
     */
    public function createPost($blogName, NPFScheme $data)
    {
        $path = $this->blogPath($blogName, '/posts');

        return $this->postRequest($path, $data->toJSON(), false);
    }

    /**
     * @param $blogName the name of the blog
     * @param $data the data to save
     *
     * @return array the response array
     */
    public function createLegacyPost($blogName, $data) {
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

        return $this->getRequest('v2/tagged', $options, true);
    }

    /**
     * Get information about a given blog
     *
     * @param  string $blogName the name of the blog to look up
     * @return BlogInfo  the response array
     */
    public function getBlogInfo($blogName)
    {
        $path = $this->blogPath($blogName, '/info');

        $result = $this->getRequest($path, null, true);
        $info = new BlogInfo($result->blog->name, $result->blog->title, $result->blog->description, $result->blog->url,
                             $result->blog->uuid, $result->blog->updated, $result->blog->posts, $result->blog->ask,
                             $result->blog->ask_anon, $result->blog->ask_page_title, $result->blog->likes,
                             $result->blog->is_blocked_from_primary, $result->blog->avatar, $result->blog->theme,
                             $result->blog->timezone_offset, $result->blog->can_chat, $result->blog->can_subscribe,
                             $result->blog->is_nsfw, $result->blog->share_likes, $result->blog->submission_page_title,
                             $result->blog->subscribed, $result->blog->is_optout_ads);
        return $info;
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

        return $this->getRedirect($path, null, true);
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

        $result = $this->getRequest($path, $options, true);
        $liked_posts = [];
        foreach($result->liked_posts as $post) {
            array_push($liked_posts, null);
        }
    }

     /**
     * Get blog followers for a given blog
     *
     * @param string $blogName the name of the blog to look up
     * @param array  $options  the options for the call
     *
     * @return array the response array
     */
    public function getBlogFollowing($blogName, $options = null)
    {
        $path = $this->blogPath($blogName, '/following');

        $result = $this->getRequest($path, $options, false);
        $blogs = [];
        foreach($result->blogs as $blog) {
            array_push($blogs, new BlogInfo($blog->name, $blog->title, $blog->description,
                                    $blog->url, $blog->uuid, $blog->updated));
        }
        $result->blogs = $blogs;
        return $result;
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

        return $this->getRequest($path, $options, true);
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
     * @return stdClass the response object (parsed)
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
