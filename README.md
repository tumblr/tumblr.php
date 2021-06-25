# tumblr.php

[![CI](https://github.com/tumblr/tumblr.php/actions/workflows/ci.yaml/badge.svg)](https://github.com/tumblr/tumblr.php/actions/workflows/ci.yaml)

The official PHP client for the [Tumblr API](https://www.tumblr.com/docs/en/api/v2).

## Usage

### Basic Usage

The first step is setting up a Client:

``` php
$client = new Tumblr\API\Client($consumerKey, $consumerSecret);
$client->setToken($token, $tokenSecret);
```

And then you can do anything you'd like:

``` php
foreach ($client->getUserInfo()->user->blogs as $blog) {
	echo $blog->name . "\n";
}
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

tumblr.php is available [on Packagist](https://packagist.org/packages/tumblr/tumblr)

* guzzle/guzzle 6.x or 7.x
* eher/oauth 1.0.x

If you're using Composer (you should!) you can just run `composer require tumblr/tumblr` and you'll be good to go.
More details on [getcomposer.org](https://getcomposer.org/).

## Running tests

tumblr.php has full unit tests that can be run with PHPUnit like this:

``` bash
php vendor/bin/phpunit
```

This will also generate a coverage report into `./build/coverage`:

```bash
XDEBUG_MODE=coverage php vendor/bin/phpunit --coverage-html=build/coverage
```

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
