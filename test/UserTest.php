<?php

class UserTest extends TumblrTest
{
    public function providerCalls()
    {
        return array(

            // getUserInfo
            array(function ($c) { $c->getUserInfo(); }, 'GET', 'v2/user/info', null),

            // getDashboardPosts
            array(function ($c) { $c->getDashboardPosts(); }, 'GET', 'v2/user/dashboard', null),
            array(function ($c) { $c->getDashboardPosts(array('limit' => 10)); }, 'GET', 'v2/user/dashboard', array('limit' => 10)),

            // getFollowedBlogs
            array(function ($c) { $c->getFollowedBlogs(); }, 'GET', 'v2/user/following', null),
            array(function ($c) { $c->getFollowedBlogs(array('limit' => 10)); }, 'GET', 'v2/user/following', array('limit' => 10)),

            // getLikedPosts
            array(function ($c) { $c->getLikedPosts(); }, 'GET', 'v2/user/likes', null),
            array(function ($c) { $c->getLikedPosts(array('limit' => 10)); }, 'GET', 'v2/user/likes', array('limit' => 10)),

            // follow
            array(function ($c) { $c->follow('b'); }, 'POST', 'v2/user/follow', array('url' => 'b.tumblr.com')),
            array(function ($c) { $c->follow('b.n'); }, 'POST', 'v2/user/follow', array('url' => 'b.n')),

            // unfollow
            array(function ($c) { $c->unfollow('b'); }, 'POST', 'v2/user/unfollow', array('url' => 'b.tumblr.com')),

            // like
            array(function ($c) { $c->like(123, 'abc'); }, 'POST', 'v2/user/like', array('id' => 123, 'reblog_key' => 'abc')),

            // unlike
            array(function ($c) { $c->unlike(123, 'abc'); }, 'POST', 'v2/user/unlike', array('id' => 123, 'reblog_key' => 'abc')),

        );
    }

}
