<?php
/**
 * A tool for grabbing a list of the blogs you're following on Tumblr,
 * and output a table of information about them, like when they last posted, and whether
 * you're mutuals or not. With a couple of command options for fun!
 *
 * This expects PHP 7.4+ as a runtime, with tumblr.php installed via composer.
 * See: Composer https://getcomposer.org/
 * See: Tumblr.php API client https://github.com/Tumblr/tumblr.php
 * See: Tumblr's API docs https://github.com/tumblr/docs/blob/master/api.md
 *
 * If you're on a Mac, I suggest using Homebrew to install php
 * See: https://brew.sh/
 * Then try:
 * $ brew install php@7.4
 * Then install Composer from the link above
 * Then try:
 * $ composer require tumblr/tumblr
 *
 * Then you have to fill in your API consumer and token details below.
 *
 * For help on how to use this, run:
 * $ php following.php help
 */

// loads our tumblr.php library automagically
require __DIR__ . '/vendor/autoload.php';

// fill in this info about your API consumer info + user token info!
// set up your own at https://www.tumblr.com/oauth/apps
$consumer_key = '';
$consumer_secret = '';
$token_key = '';
$token_secret = '';
date_default_timezone_set('US/Eastern'); // also, update this to your timezone!

echo 'Following info script! Hello!' . "\n";

// show help info if we're asked
if (($argv[1] ?? null) === 'help') {
    echo 'Run with no arguments for the default, which is to list all followed blogs by last updated time:' ."\n";
    echo '$ php following.php' . "\n";
    echo 'Or pass along some arguments. The first one is the sort order, the second is mutuals only or not:' . "\n";
    echo '$ php following.php last_updated 1' . "\n";
    echo 'Sort order can be "last_updated" or "alphabetical", mutuals only can be 1 (yes) or 0 (no).' . "\n";
    exit(0);
}

if ($consumer_key === '' || $consumer_secret === '' || $token_key === '' || $token_secret === '') {
    echo 'You need to fill out your consumer key, consumer secret, token key, and token secret in this script for it to work.' . "\n";
    exit(1);
}

$tumblr = new \Tumblr\API\Client($consumer_key, $consumer_secret, $token_key, $token_secret);

// figure out our configurable options
$sort_by = $argv[1] ?? 'last_updated';
$mutuals_only = boolval($argv[2] ?? false) ?? false;

echo 'Sorting by: ' . $sort_by . "\n";
echo 'Mutuals only? ' . ($mutuals_only ? 'yeah' : 'nope') . "\n";

$blogs = []; // we'll keep the blog objects here for display later
$next_offset = 0; // keep track of the next offset to ask for

echo "Fetching the blogs you're following, this may take awhile depending on how many you follow.\n";

// while we have an offset, keep asking Tumblr for the blogs we're following
while ($next_offset !== null) {
    $blogs_response = $tumblr->getFollowedBlogs([
        // some special fields that we can use to learn more
        'fields' => [
            'blogs' => 'name,updated,url,?duration_blog_following_you,?duration_following_blog',
        ],
        'offset' => $next_offset,
    ]);

    // if we have a next offset to use, capture it for the next loop
    $next_offset = $blogs_response->_links->next->query_params->offset ?? null;

    foreach ($blogs_response->blogs as $blog_object) {
        $blogs[] = $blog_object; // for sorting after we fetch all of them
    }

    // be nice to the API and sleep for a second between each request,
    // or else it may rate limit us
    if ($next_offset !== null) {
        sleep(1);
    }

    echo '.'; // love logging dots as progress
}

echo ' done!' . "\n";

// our default sorting option, latest-first
function sort_blogs_last_updated_first($blog1, $blog2) {
    return $blog2->updated <=> $blog1->updated;
}

// another sorting option, basic alphabetical
function sort_blogs_alphabetically($blog1, $blog2) {
    return $blog1->name <=> $blog2->name;
}

switch ($sort_by) {
    case 'last_updated':
        usort($blogs, 'sort_blogs_last_updated_first');
        break;
    case 'alphabetical':
        usort($blogs, 'sort_blogs_alphabetically');
        break;
    default:
        // lol, always have a fallback
        echo 'Actually I have no idea how to sort the list, you gave me an invalid option...' . "\n";
}

// let's keep track of some stuff to show at the end
$mutual_counter = 0;
$following_count = 0;
$now = time();
$oldest_mutual_name = null;
$oldest_mutual_duration = null;

// manually doing some spacing here as an uncomplicated hack
echo "blog name                         last updated time      mutual status \n";
$max_name_length = 32; // we'll use this to determine the padding after each blog name

// let's go through each blog and write out some data
foreach ($blogs as $blog) {
    $mutuals = $blog->duration_blog_following_you > -1 && $blog->duration_following_blog > -1;
    if ($mutuals_only && !$mutuals) {
        continue; // skip if we're only showing mutuals
    }

    echo $blog->name; // we also have $blog->url

    // figure out how much padding is needed to make the output look nice
    $padding = $max_name_length - strlen($blog->name) + 2;
    for ($i = 0; $i < $padding; $i++) {
        echo ' ';
    }

    echo date('Y-m-d h:i A', $blog->updated);
    echo "    ";

    if ($mutuals) {
        echo 'Mutuals!';
        $mutual_counter++;
        if ($oldest_mutual_duration === null || $oldest_mutual_duration < $blog->duration_blog_following_you) {
            $oldest_mutual_duration = $blog->duration_blog_following_you;
            $oldest_mutual_name = $blog->name;
        }
    } else {
        echo 'Not mutuals.';
    }

    echo "\n";
    $following_count++;
}

// output some interesting info at the end as well
if ($mutuals_only) {
    echo sprintf('You have %d mutuals!', $mutual_counter) . "\n";
} else {
    echo sprintf('Following %d blogs, %d of which are mutuals', $following_count, $mutual_counter) . "\n";
}

// if we have an "oldest" mutual, give us some info about them as well
if ($oldest_mutual_name !== null) {
    echo sprintf(
            'Your oldest mutual is %s who has been following you since %s!',
            $oldest_mutual_name,
            date('F d, Y', $now - $oldest_mutual_duration)
        ) . "\n";
}

echo "Thanks for calling! Have a nice day! \n";
