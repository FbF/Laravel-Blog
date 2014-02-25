<?php

/**
 * Images configuration options
 */
return array(

	/**
	 * By default, there is only one image field, but if you extend the package to add more images per record, you
	 * can add config for those images here. This will allow you to use the package model methods for getting the
	 * settings for a particular image.
	 *
	 * The keys correspond to the field names in your database table.
	 */
	'main_image' => array(

		/**
		 * Whether the Main Image field is shown in the administrator config, and whether it's created for the seed
		 */
		'show' => true,

		/**
		 * Settings for the original image uploaded
		 */
		'original' => array(

			/**
			 * Location, relative to public_path(), where the image is stored.
			 */
			'dir' => '/uploads/packages/fbf/laravel-blog/main_image/original/',

		),

		/**
		 * Settings for the various sizes of the images that are created from the original
		 */
		'sizes' => array(

			/**
			 * The thumbnail size is used on the list view
			 */
			'thumbnail' => array(
				'dir' => '/uploads/packages/fbf/laravel-blog/main_image/thumbnail/',
				'method' => 'crop',
				'width' => 150,
				'height' => 150,
			),

			/**
			 * The resized size is used on the details view
			 */
			'resized' => array(
				'dir' => '/uploads/packages/fbf/laravel-blog/main_image/resized/',
				'method' => 'crop',
				'width' => 400,
				'height' => 400,
			),
		),
	),
);