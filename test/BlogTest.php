<?php

class BlogTest extends TumblrTest
{
    public function providerCalls()
    {
        $test = $this; // for inner context

        return array(

            // getBlogInfo
            array(function ($c) { $c->getBlogInfo('b'); }, 'GET', 'v2/blog/b.tumblr.com/info', array('api_key' => API_KEY)),

            // getBlogAvatar
            array(function ($c) use ($test) {
                $url = $c->getBlogAvatar('b');
                $test->assertEquals($url, 'url');
            }, 'GET', 'v2/blog/b.tumblr.com/avatar', array('api_key' => API_KEY), 'redirect'),
            array(function ($c) use ($test) {
                $url = $c->getBlogAvatar('b');
                $test->assertEquals($url, null);
            }, 'GET', 'v2/blog/b.tumblr.com/avatar', array('api_key' => API_KEY), 'not_found'),
            array(function ($c) { $c->getBlogAvatar('b', 128); }, 'GET', 'v2/blog/b.tumblr.com/avatar/128', array('api_key' => API_KEY)),

            // getBlogLikes
            array(function ($c) { $c->getBlogLikes('b.n'); }, 'GET', 'v2/blog/b.n/likes', array('api_key' => API_KEY)),
            array(function ($c) { $c->getBlogLikes('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/likes', array('limit' => 10, 'api_key' => API_KEY)),

            // getBlogFollowers
            array(function ($c) { $c->getBlogFollowers('b.n'); }, 'GET', 'v2/blog/b.n/followers', null),
            array(function ($c) { $c->getBlogFollowers('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/followers', array('limit' => 10)),

            // getBlogPosts
            array(function ($c) { $c->getBlogPosts('b.n'); }, 'GET', 'v2/blog/b.n/posts', array('api_key' => API_KEY)),
            array(function ($c) { $c->getBlogPosts('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/posts', array('limit' => 10, 'api_key' => API_KEY)),
            array(function ($c) { $c->getBlogPosts('b.n', array('type' => 'text')); }, 'GET', 'v2/blog/b.n/posts/text', array('api_key' => API_KEY)),

            // getQueuedPosts
            array(function ($c) { $c->getQueuedPosts('b.n'); }, 'GET', 'v2/blog/b.n/posts/queue', null),
            array(function ($c) { $c->getQueuedPosts('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/posts/queue', array('limit' => 10)),

            // getDraftPosts
            array(function ($c) { $c->getDraftPosts('b.n'); }, 'GET', 'v2/blog/b.n/posts/draft', null),
            array(function ($c) { $c->getDraftPosts('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/posts/draft', array('limit' => 10)),

            // getSubmissionPosts
            array(function ($c) { $c->getSubmissionPosts('b.n'); }, 'GET', 'v2/blog/b.n/posts/submission', null),
            array(function ($c) { $c->getSubmissionPosts('b.n', array('limit' => 10)); }, 'GET', 'v2/blog/b.n/posts/submission', array('limit' => 10)),

        );
    }

    public function testNotFound()
    {
        try {
            $this->testCalls(function ($c) {
                $c->getBlogInfo('b');
            }, 'GET', 'v2/blog/b.tumblr.com/info', array('api_key' => API_KEY), 'not_found');
        } catch (\Tumblr\API\RequestException $e) {
            $this->assertEquals((string) $e, "Tumblr\API\RequestException: [404]: Unknown Error\n");

            return;
        }
        $this->fail('no error thrown');
    }

}
