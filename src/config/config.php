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
	 * Determines whether to show the share partial on the post view page
	 *
	 * @type bool
	 */
	'show_share_partial_on_view' => true,

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

	/**
	 * The view to use for the posts index page. You can change this to a view in your
	 * app, and inside your own view you can @include the various elements in the package
	 * or you can use this one provided, but there's no layout or anything.
	 */
	'index_view' => 'laravel-blog::posts.index',

	/**
	 * The view to use for the post detail page. You can change this to a view in your
	 * app, and inside your own view you can @include the various elements in the package
	 * or you can use this one provided, but there's no layout or anything.
	 */
	'view_view' => 'laravel-blog::posts.view',

	/**
	 * The path, relative to the public_path() directory, where the original images are stored.
	 */
	'originals_dir' => '/uploads/packages/fbf/laravel-blog/originals/',

	/**
	 * The path, relative to the public_path() directory, where the thumbnail images are stored.
	 */
	'thumbnails_image_dir' => '/uploads/packages/fbf/laravel-blog/thumbnails/',

	/**
	 * The width of the thumbnail images.
	 */
	'thumbnail_image_width' => 200,

	/**
	 * The height of the thumbnail images.
	 */
	'thumbnail_image_height' => 150,

	/**
	 * The path, relative to the public_path() directory, where the details images are stored.
	 */
	'details_image_dir' => '/uploads/packages/fbf/laravel-blog/details/',

	/**
	 * The max width of the details page images. The resized version of images will fit within this size
	 */
	'details_image_max_width' => 450,

	/**
	 * The max height of the details page images. The resized version of images will fit within this size
	 */
	'details_image_max_height' => 450,

	/**
	 * YouTube Embed Player code used if a post has a You Tube Video ID set
	 * instead of an Image. Changing the settings will apply to all pages that
	 * have a You Tube Video on them. The placeholder "%YOU_TUBE_VIDEO_ID%" is
	 * replaced with the You Tube Video ID in the database for this page.
	 */
	'you_tube_embed_code' => '<iframe width="560" height="315" src="//www.youtube.com/embed/%YOU_TUBE_VIDEO_ID%?rel=0" frameborder="0" allowfullscreen></iframe>',

	/**
	 * YouTube Thumbnail code used if a post has a You Tube Video ID set
	 * instead of an Image. Changing the settings will apply to all entries on the index pages for posts that
	 * have a You Tube Video . The placeholder "%YOU_TUBE_VIDEO_ID%" is
	 * replaced with the You Tube Video ID in the database for this page.
	 */
	'you_tube_thumbnail_code' => '<img src="//img.youtube.com/vi/%YOU_TUBE_VIDEO_ID%/mqdefault.jpg" width="200" height="150" />',

	'seed' => array(

		/**
		 * Should the seeder append (replace = false) or replace (true)
		 */
		'replace' => true,

		/**
		 * List of the you tube video ids that could be used
		 */
		'you_tube_video_ids' => array(
			'dQw4w9WgXcQ'
		),

		/**
		 * One in every X posts is a YouTube Video (use 0 for no YouTube Videos)
		 */
		'you_tube_video_freq' => 5,

		/**
		 * One in every X posts that is not a YouTube Video, has an image (use 0 for no images)
		 */
		'image_freq' => 2,

	),

);