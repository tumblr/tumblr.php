<?php

class TaggedTest extends TumblrTest
{
    public function providerCalls()
    {
        return array(

            // getTaggedPosts
            array(function ($c) { $c->getTaggedPosts('hey'); }, 'GET', 'v2/tagged', array('tag' => 'hey', 'api_key' => API_KEY)),
            array(function ($c) { $c->getTaggedPosts('hey', array('limit' => 10)); }, 'GET', 'v2/tagged', array('limit' => 10, 'tag' => 'hey', 'api_key' => API_KEY)),

        );
    }

}
