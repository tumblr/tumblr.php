<?php

use Tumblr\API\Write\NPFScheme;
use Tumblr\API\NPF\Content\TextBlock;

class PostTest extends TumblrTest
{
    public function providerCalls()
    {
        return array(

            /**
             * Execute delete request for existing post
             */
            array(function ($c) { $c->deletePost('b', 123, 'abc'); }, 'POST', 'v2/blog/b.tumblr.com/post/delete', array('id' => 123, 'reblog_key' => 'abc')),

            // reblog post
            array(function ($c) { $c->reblogPost('b', 123, 'abc'); }, 'POST', 'v2/blog/b.tumblr.com/post/reblog', array('id' => 123, 'reblog_key' => 'abc')),
            array(function ($c) { $c->reblogPost('b', 123, 'abc', array('something' => 'else')); }, 'POST', 'v2/blog/b.tumblr.com/post/reblog', array('id' => 123, 'reblog_key' => 'abc', 'something' => 'else')),

            // edit post
            array(function ($c) { $c->editPost('b.n', 123, new NPFScheme(null, [
                new TextBlock("Hello World")
            ])); 
            }, 
            'POST', 'v2/blog/b.n/posts/123',
            '{"content":[{"text":"Hello World","subtype":"","formatting":[],"type":"text"}],"layout":[],"state":"published","publish_on":"","tags":"","source_url":"","send_to_twitter":false,"send_to_facebook":false}'),

            array(function ($c) { $c->editLegacyPost('b.n', 123, array('source' => 'remote')); }, 'POST', 'v2/blog/b.n/post/edit', array('source' => 'remote', 'id' => 123)),

            // create post
            array(function ($c) { $c->createPost('b.n', new NPFScheme(null, [
                    new TextBlock("Hello World")
                ]));
                }, 'POST', 'v2/blog/b.n/posts',
                '{"content":[{"text":"Hello World","subtype":"","formatting":[],"type":"text"}],"layout":[],"state":"published","publish_on":"","tags":"","source_url":"","send_to_twitter":false,"send_to_facebook":false}'),

            // single source
            array(function ($c) { $c->createLegacyPost('b.n', array('source' => 'remote')); }, 'POST', 'v2/blog/b.n/post', array('source' => 'remote')),

            // multi-source
            array(function ($c) { $c->createLegacyPost('b.n', array('source' => array('r1', 'r2'))); }, 'POST', 'v2/blog/b.n/post', array('source[0]' => 'r1', 'source[1]' => 'r2')),

        );
    }
}
