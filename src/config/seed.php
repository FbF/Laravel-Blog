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
	 * Configuration options for the seeder dates
	 */
	'dates' => array(

		/**
		 * Options for the text dates column
		 */
		'text_dates' => array(
			'25<sup>th</sup> December 0000',
			'December 31, 9pm until late',
			'Tuesday - Wednesday, w/c 24/2/2014',
			'1 Feb',
			'12 - 15 February 2014',
			'From 2014-02-24 21:15:00T0100 to 2014-02-25 22:15:30T0100',
		),

		/**
		 * One in every X posts spans more than 1 day (use 0 for no multi-day posts)
		 */
		'multi_day_freq' => 5,
	),

	/**
	 * Configuration options for the seeder links
	 */
	'link' => array(

		/**
		 * One in every X posts has a link (use 0 for no links)
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

	/**
	 * Configuration options for the seeder maps
	 */
	'map' => array(

		/**
		 * One in every X posts has a map (use 0 for no maps)
		 */
		'freq' => 2,

		/**
		 *
		 */
		'marker' => array(
			'latitude' => array(
				'min' => -90,
				'max' => 90,
			),
			'longitude' => array(
				'min' => -180,
				'max' => 180,
			),

		),

	),

);