# Getting Started with the Tumblr API

This is a quick-start guide to making something with Tumblr's public API. It assumes very little prior knowledge of programming, but to get the most out of Tumblr's API, you'll need to learn some concepts and do some setup. From here, you can dive into some of the examples in this folder for more!

## What is the Tumblr API?

The Tumblr API is a publicly-accessible interface for getting information out of or into Tumblr, such as a blog's posts, your own likes, or search results for a certain tag. The Tumblr API is what powers Tumblr itself, including our website and our mobile apps. The API is what provides the details about what you're seeing on Tumblr. The website and our mobile apps are just our officially-supported ways of accessing Tumblr, but you can build your own!

## How to set up your first Tumblr API application

To get started, [check out our public documentation about using the API](https://github.com/tumblr/docs/blob/master/api.md). This will be your primary resource for figuring out what you want to do, how to do it, and what different Tumblr-specific things mean.

Next, go to [the developer applications page](https://www.tumblr.com/oauth/apps), and click "Register application" to set up your first API application. Fill in the required information, but note for the purposes of this guide, what you put inside "Default callback URL" and "OAuth2 redirect URLs" doesn't actually matter, so put whatever you want.

Once you've created your first application, it should appear under "[Applications](https://www.tumblr.com/oauth/apps)", and you'll be able to get your "OAuth Consumer Key" and "Secret Key". They'll look like long sequences of numbers and letters. As the name implies, please keep that secret key a secret! Don't give it to other people. These two things are what identify your application to us at Tumblr.

## Getting your own Tumblr API OAuth credentials

Now that you have your OAuth consumer key and secret, you can get some credentials to try to get information from the Tumblr API using your actual account. You can also start playing with the Tumblr API Console. To get these credentials, go to [the API console](https://api.tumblr.com/console) and enter your new consumer key and secret, and then click "Authenticate". You'll be redirected to a page that authorizes your application to use your account, and when you accept that and land on the API console, you'll be given a demo of using one of our Tumblr API libraries, along with a "Token" and "Token Secret".

Those two long jumbles of numbers and letters, the "Token" and "Token secret", represent your account, so keep them secret, just like you should keep the OAuth Consumer Secret Key a secret! With all four of these pieces of information, you can hit the Tumblr API and get all kinds of info, and even make posts, see who you're following, do searches, etc.

## Installing PHP, Composer, and Tumblr.php

We'll use [PHP](https://www.php.net/) as our programming language for examples in this folder. If you're on a Mac, the easiest way to install PHP is to open up the Terminal app, [install Homebrew](https://brew.sh/), and then run "brew install php" in Terminal after Homebrew is installed. (We'll be spending a lot of time in the Terminal app.) After PHP installs, you should be able to run `php --version` in Terminal to see what version of PHP you have. If you're using Windows, you'll likely use [PowerShell](https://docs.microsoft.com/en-us/powershell/) instead of Terminal, and you'll have to [install the PHP binaries manually](https://windows.php.net/download).

Next, we need to install [Composer](https://getcomposer.org/), which is a PHP tool that will help you install the Tumblr PHP API client library. Luckily, if you installed Homebrew, you'll be able to just run `brew install composer` to get it. Otherwise, [download Composer to install it](https://getcomposer.org/download/) (if you're on Windows, you should follow those instructions).

From here, check out [the Following List example](following-list) to write a script that gets who you're following and shows more information than what we do in the actual Following screen on Tumblr itself.