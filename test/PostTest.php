<?php

class PostTest extends TumblrTest
{
    public function providerCalls()
    {
        return array(

            // delete post
            array(function ($c) { $c->deletePost('b', 123, 'abc'); }, 'POST', 'v2/blog/b.tumblr.com/post/delete', array('id' => 123, 'reblog_key' => 'abc')),

            // reblog post
            array(function ($c) { $c->reblogPost('b', 123, 'abc'); }, 'POST', 'v2/blog/b.tumblr.com/post/reblog', array('id' => 123, 'reblog_key' => 'abc')),
            array(function ($c) { $c->reblogPost('b', 123, 'abc', array('something' => 'else')); }, 'POST', 'v2/blog/b.tumblr.com/post/reblog', array('id' => 123, 'reblog_key' => 'abc', 'something' => 'else')),

            // edit post
            array(function ($c) { $c->editPost('b.n', 123, array('d' => 'ata')); }, 'POST', 'v2/blog/b.n/post/edit', array('d' => 'ata', 'id' => 123)),

            // create post
            array(function ($c) { $c->createPost('b.n', array('d' => 'ata')); }, 'POST', 'v2/blog/b.n/post', array('d' => 'ata')),

        );
    }
}
