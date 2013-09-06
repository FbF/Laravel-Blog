<?php

return array(

	/**
	 * URI of the blog
	 */
	'uri' => 'blog',

	/**
	 * Page title of the blog index page
	 *
	 * @type string
	 */
	'index_page_title' => 'My blog',

	/**
	 * Meta description of the blog index page
	 *
	 * @type string
	 */
	'index_page_meta_description' => 'This is the description for my blog',

	/**
	 * Meta keywords of the blog index page
	 *
	 * @type string
	 */
	'index_page_meta_keywords' => 'These are the keywords for my blog',

	/**
	 * RSS feed title
	 *
	 * @type string
	 */
	'rss_feed_title' => 'My blog',

	/**
	 * RSS feed description
	 *
	 * @type string
	 */
	'rss_feed_description' => 'This is the description for my blog',

	/**
	 * Determines whether to show adjacent (i.e. previous and next) post links on the post view page
	 *
	 * @type bool
	 */
	'show_adjacent_posts_on_view' => true,

	/**
	 * Determines whether to show the archives on the index page
	 *
	 * @type bool
	 */
	'show_archives_on_index' => true,

	/**
	 * Determines whether to show the archives on the view page
	 *
	 * @type bool
	 */
	'show_archives_on_view' => true,

	/**
	 * The number of posts to show per page on the index
	 *
	 * @type int
	 */
	'results_per_page' => 4,

	/**
	 * Date format for published date, shown on posts.index and posts.view. Should be
	 * a valid date() format string, e.g.
	 *
	 * @type string
	 */
	'published_date_format' => 'j\<\s\u\p\>S\<\/\s\u\p\> F \'y',

);