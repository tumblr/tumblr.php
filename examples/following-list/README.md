# A simple demo script: Information about who you're following

The end result of this tutorial is a script that'll list out who you're following, showing who you're mutuals with and when they last posted.

## Install dependencies

If you followed along from the example folder README, you're halfway there.

Once Composer is installed, we'll want to create a folder for our project. Make a folder anywhere, such as in your local Documents folder, and then go there in Terminal (or PowerShell on Windows). If you used your Documents folder and made a new folder there, then the command to go there will be `cd ~/Documents/your-folder-name-here`

When you're inside that new project folder, run `composer require tumblr/tumblr` in Terminal (or PowerShell) to install [the official PHP Tumblr API client](https://github.com/tumblr/tumblr.php). Then, create a new file for our demonstration script, named `following.php`, and open that in a text editor of some kind. At Tumblr, we like [PHPStorm](https://www.jetbrains.com/phpstorm/) (paid) and [Visual Studio Code](https://code.visualstudio.com/) (free) a lot, but any "plain text" editor will do. (Note that text editors like Microsoft Word or Google Docs are not "plain text", so they won't necessarily work.)

## Creating our script

The first thing to do in your new `following.php` file is to just "echo" something to make sure PHP is working. So just put in:

```php
<?php

echo 'hello!';
```

... and save the file, and in Terminal (or PowerShell), type in `php following.php` and press Enter/Return, and you should see "hello!" – congratulations, you just wrote a PHP script!

From here, we need to import our Composer packages, of which Tumblr's API client is included, so replace everything in the "following.php" file with:

```php
<?php

// this loads our tumblr.php library automagically
require __DIR__ . '/vendor/autoload.php';
```

... and now let's set up the Tumblr API client itself, so we can start asking Tumblr for information. After the above four lines, add these:

```php
$consumer_key = ''; // put your consumer key between the ‘'
$consumer_secret = ''; // put your consumer secret between the ‘'
$token_key = ''; // put your token between the ‘'
$token_secret = ''; // put your token secret between the ‘'

$tumblr = new \Tumblr\API\Client($consumer_key, $consumer_secret, $token_key, $token_secret);
```

... and fill all of that information out as described. There's an example of the kinds of data this expects in [the User Info console page](https://api.tumblr.com/console/calls/user/info). 

And now let's add to the end of the file our first actual call to the Tumblr API:

```php
$blogs_response = $tumblr->getFollowedBlogs();
foreach ($blogs_response->blogs as $blog) {
    echo "{$blog->url}\n";
}
```

... and if you run `php following.php` now, you'll likely get a list of blog URLs you're following, which is actually the first "page" of who you're following on Tumblr. Congratulations, you've just used the Tumblr API!

From here, you'll have to [learn PHP](https://www.php.net/manual/en/getting-started.php), [our PHP client library](https://github.com/tumblr/tumblr.php), and [the Tumblr API endpoints and fields](https://github.com/tumblr/docs/blob/master/api.md) to do more. 

As a bigger, more complete example, in this folder is a more complete `following.php` script you can run, as promised at the start of this guide. Copy that script somewhere, run the composer install as described at the top of the file, and run `php following.php help` for more information on what it can do!
