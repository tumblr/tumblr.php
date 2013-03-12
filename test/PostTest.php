<?php

class PostTest extends TumblrTest
{
    public function providerCalls()
    {
        return array(

            // delete post
            array(function ($c) { $c->deletePost('b', 123, 'abc'); }, 'POST', 'v2/blog/b.tumblr.com/post/delete', array('id' => 123, 'reblog_key' => 'abc')),

        );
    }
}
