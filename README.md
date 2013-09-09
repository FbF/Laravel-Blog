Simple-Blog
===========

A Laravel 4 package to add a simple blog to a site

## Features

* Paginated index view with configurable results per page
* Year/Month archive filtering
* Draft/Approved status
* Soft deletes
* Configurable URLs, e.g. /blog or /news/yyyy/mm or /articles/< article slug >
* Fields for title, slug, image, summary, content, published date, status, meta description and keywords, in RSS?

## Installation

Add the following to you composer.json file

    "fbf/simple-blog": "dev-master"

Run

    composer update

Add the following to app/config/app.php

    'Fbf\SimpleBlog\SimpleBlogServiceProvider'

Run the package migration

    php artisan migrate --package=fbf/simple-blog

Publish the config

    php artisan config:publish fbf/simple-blog

## Configuration

URI of the blog

	'uri' => 'blog',

Page title of the blog index page

	'index_page_title' => 'My blog',

Meta description of the blog index page

	'index_page_meta_description' => 'This is the description for my blog',

Meta keywords of the blog index page

	'index_page_meta_keywords' => 'These are the keywords for my blog',

RSS feed title

	'rss_feed_title' => 'My blog',

RSS feed description

	'rss_feed_description' => 'This is the description for my blog',

Determines whether to show adjacent (i.e. previous and next) post links on the post view page

	'show_adjacent_posts_on_view' => true,

Determines whether to show the archives on the index page

	'show_archives_on_index' => true,

Determines whether to show the archives on the view page

	'show_archives_on_view' => true,

The number of posts to show per page on the index

	'results_per_page' => 4,

Date format for published date, shown on posts.index and posts.view. Should be a valid date() format string, e.g.

	'published_date_format' => 'j\<\s\u\p\>S\<\/\s\u\p\> F \'y',

## Administrator

You can use the excellent Laravel Administrator package by frozennode to administer your blog.

http://administrator.frozennode.com/docs/installation

A ready-to-use model config file for the Post model (posts.php) is provided in the src/config/administrator directory of the package, which you can copy into the app/config/administrator directory (or whatever you set as the model_config_path in the administrator config file).