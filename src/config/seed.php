<?php

/**
 * Config settings for the Seed
 */
return array(

	/**
	 * Should the seeder append (replace = false) or replace (true)
	 */
	'replace' => true,

	/**
	 * Number of fake posts to create
	 */
	'number' => 20,

	/**
	 * Configuration options for YouTube for the fake seeder
	 */
	'you_tube' => array(

		/**
		 * One in every X posts is a YouTube Video (use 0 for no YouTube Videos, or set you_tube.show to false)
		 */
		'freq' => 5,

		/**
		 * List of the you tube video ids that could be used
		 */
		'video_ids' => array(
			'dQw4w9WgXcQ'
		),

	),

	/**
	 * Configuration options for the images for the fake seeder
	 */
	'images' => array(

		/**
		 * Configuration options for the main image for the fake seeder
		 */
		'main_image' => array(

			/**
			 * One in every X posts that is not a YouTube Video, has a main image (use 0 for no main images, or set
			 * images.main_image.show to false)
			 */
			'freq' => 2,

			/**
			 * Lorem Pixel category to use for the main image
			 */
			'category' => 'abstract',

			/**
			 * Width of the original image to fetch by the fake seeder
			 */
			'original_width' => 400,

			/**
			 * Height of the original image to fetch by the fake seeder
			 */
			'original_height' => 400,

		),

	),

	/**
	 * Configuration options for the seeder links
	 */
	'link' => array(

		/**
		 * One in every X items has a link (use 0 for no links)
		 */
		'freq' => 2,

		/**
		 * Options for the link text
		 */
		'texts' => array(
			'Visit website',
			'Read more',
			'Find out more',
			'Go to the official site',
			'Check this out'
		),

		/**
		 * Options for the link urls
		 */
		'urls' => array(
			'http://www.google.com',
			'http://www.bbc.co.uk',
			'http://www.fivebyfiveuk.com',
		),

	),

);