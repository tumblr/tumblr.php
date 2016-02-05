# tumblr.php

[![Build Status](https://secure.travis-ci.org/tumblr/tumblr.php.png)](http://travis-ci.org/tumblr/tumblr.php)

The official PHP client for the
[Tumblr API](http://www.tumblr.com/docs/en/api/v2).

## Usage

### Authentication

This client allows you to use one of these authentication levels:

- API key
- OAuth

Using API key, the simplest one, you just need to set the client with you Consumer Key, provided by [Tumblr API](https://www.tumblr.com/oauth/apps), like this
``` php
$client = new Tumblr\API\Client($consumerKey);
```
for use methods which are accessible from the API key. E.g.
``` php
$client->getBlogInfo($blogName);
```
The OAuth level is a little more complex, because it gives more access to user account. You need tokens which are provided only by user authorization. To obtain these tokens, first you need to:

- Guarantee that your application credentials are valid
- Tell which page should the user return to
- Redirect user to the Tumblr authorization page

So let's consider you are coding the page `https://example.com/auth/tumblr`. You must configure your client with your application credentials, provided by [OAuth](https://www.tumblr.com/oauth/apps)
``` php
$client = new Tumblr\API\Client($consumerKey, $consumerSecret);
```
Point the request handler to Tumblr
``` php
$requestHandler = $client->getRequestHandler();
$requestHandler->setBaseUrl('https://www.tumblr.com/');
```
And then send the request to Tumblr with your callback URL. Let's consider it would be `https://example.com/auth/tumblr/callback`.
``` php
$response = $requestHandler->request('POST', 'oauth/request_token', [
    'oauth_callback' => 'https://example.com/auth/tumblr/callback'
]);
```
If your credentials are valid, you should receive temporary tokens to continue. You may extract them this way
``` php
parse_str((string) $response->body, $tokens);
```
`$tokens` will contain
``` php
['oauth_token' => '...', 'oauth_token_secret' => '...']
```
Save these tokens somehow (e.g. using `$_SESSION`), because we're going to use them in the next session. Now, the user must be redirected to URL `https://www.tumblr.com/oauth/authorize?oauth_token={$tokens['oauth_token']}`.

Now, the user should decide if authorizes your application and then should be redirected to your callback page with 'get' param `oauth_verifier`. Now let's consider you're coding the page `https://example.com/auth/tumblr/callback`. One more time you should set the client with your application credentials and termporary tokens stored in the last session.
``` php
$client = new Tumblr\API\Client($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
```
Again let's point the request handler to Tumblr
``` php
$requestHandler = $client->getRequestHandler();
$requestHandler->setBaseUrl('https://www.tumblr.com/');
```
And send the request to Tumblr with param `oauth_verifier`, at this time receiving the definitive tokens
``` php
$response = $requestHandler->request('POST', 'oauth/access_token', [
    'oauth_verifier' => $oauthVerifier
]);
```
You can also use the variable `$_GET` to recover `$oauthVerifier`.

If everything runs correctly, you should receive the definitive tokens, which may be extracted this way
``` php
parse_str((string) $response->body, $tokens);
```
Remember: you can verify the response status with `$response->status`. If everything runs correctly, the status will be `200`. Otherwise, will be `401`. You can see all status [here](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html).

Finally, you can use any method provided by client.
``` php
$client = new Tumblr\API\Client($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
$client->getUserInfo();
```

### User Methods

``` php
$client->getUserInfo();

$client->getDashboardPosts($options = null);
$client->getLikedPosts($options = null);
$client->getFollowedBlogs($options = null);

$client->follow($blogName);
$client->unfollow($blogName);

$client->like($postId, $reblogKey);
$client->unlike($postId, $reblogKey);
```

### Blog Methods

``` php
$client->getBlogInfo($blogName);

$client->getBlogAvatar($blogName, $size = null);

$client->getBlogPosts($blogName, $options = null);
$client->getBlogLikes($blogName, $options = null);
$client->getBlogFollowers($blogName, $options = null);

$client->getQueuedPosts($blogName, $options = null);
$client->getDraftPosts($blogName, $options = null);
$client->getSubmissionPosts($blogName, $options = null);
```

### Post Methods

``` php
$client->createPost($blogName, $data);
$client->editPost($blogName, $id, $data);
$client->deletePost($blogName, $id, $reblogKey);
$client->reblogPost($blogName, $id, $reblogKey, $options = null);
```

### Tagged Methods

``` php
$client->getTaggedPosts($tag, $options = null);
```

## Dependencies

tumblr.php is available
[on composer](https://packagist.org/packages/tumblr/tumblr)

* guzzle/guzzle >=3.1.x,<4 
* eher/oauth 1.0.x

If you're using composer (you should!) you can just run
`php composer.phar install` and you'll be good to go.  More details on
[getcomposer.org](http://getcomposer.org/).

## Running tests

tumblr.php has full unit tests that can be run with PHPUnit like this:

``` bash
$ phpunit
```

That will also generate a coverage report into `./coverage`

## Copyright and license

Copyright 2013 Tumblr, Inc.

Licensed under the Apache License, Version 2.0 (the "License"); you may not
use this work except in compliance with the License. You may obtain a copy of
the License in the LICENSE file, or at:

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
License for the specific language governing permissions and limitations.
