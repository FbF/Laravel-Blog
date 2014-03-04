<?php

return array(

	/**
	 * Model title
	 *
	 * @type string
	 */
	'title' => 'Posts',

	/**
	 * The singular name of your model
	 *
	 * @type string
	 */
	'single' => 'post',

	/**
	 * The class name of the Eloquent model that this config represents
	 *
	 * @type string
	 */
	'model' => 'Fbf\LaravelBlog\Post',

	/**
	 * The columns array
	 *
	 * @type array
	 */
	'columns' => array(
		'title' => array(
			'title' => 'Title'
		),
		'published_date' => array(
			'title' => 'Published'
		),
		'status' => array(
			'title' => 'Status',
			'select' => "CASE (:table).status WHEN '".Fbf\LaravelBlog\Post::APPROVED."' THEN 'Approved' WHEN '".Fbf\LaravelBlog\Post::DRAFT."' THEN 'Draft' END",
		),
		'updated_at' => array(
			'title' => 'Last Updated'
		),
	),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'title' => array(
			'title' => 'Title',
			'type' => 'text',
		),
		'slug' => array(
			'title' => 'Slug',
			'type' => 'text',
			'visible' => function($model)
				{
					return $model->exists;
				},
		),
		'main_image' => array(
			'title' => 'Main Image',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path() . Config::get('laravel-blog::images.main_image.original.dir'),
			'size_limit' => 5,
			'sizes' => array(
				array(
					Config::get('laravel-blog::images.main_image.sizes.thumbnail.width'),
					Config::get('laravel-blog::images.main_image.sizes.thumbnail.height'),
					Config::get('laravel-blog::images.main_image.sizes.thumbnail.method'),
					public_path() . Config::get('laravel-blog::images.main_image.sizes.thumbnail.dir'),
					100
				),
				array(
					Config::get('laravel-blog::images.main_image.sizes.resized.width'),
					Config::get('laravel-blog::images.main_image.sizes.resized.height'),
					Config::get('laravel-blog::images.main_image.sizes.resized.method'),
					public_path() . Config::get('laravel-blog::images.main_image.sizes.resized.dir'),
					100
				),
			),
		),
		'main_image_alt' => array(
			'title' => 'Image ALT text',
			'type' => 'text',
		),
		'you_tube_video_id' => array(
			'title' => 'YouTube Video ID (Takes precedence over the image if it\'s populated)',
			'type' => 'text',
		),
		'summary' => array(
			'title' => 'Summary',
			'type' => 'textarea',
			'limit' => 300, //optional, defaults to no limit
			'height' => 130, //optional, defaults to 100
		),
		'content' => array(
			'title' => 'Content',
			'type' => 'wysiwyg',
		),
		'link_text' => array(
			'title' => 'Link Text',
			'type' => 'text',
			'visible' => Config::get('laravel-blog::link.show'),
		),
		'link_url' => array(
			'title' => 'Link URL',
			'type' => 'text',
			'visible' => Config::get('laravel-blog::link.show'),
		),
		'is_sticky' => array(
			'title' => 'Is sticky?',
			'type' => 'bool',
		),
		'in_rss' => array(
			'title' => 'In RSS Feed?',
			'type' => 'bool',
		),
		'meta_description' => array(
			'title' => 'Page Title',
			'type' => 'text',
		),
		'meta_description' => array(
			'title' => 'Meta Description',
			'type' => 'textarea',
		),
		'meta_keywords' => array(
			'title' => 'Meta Keywords',
			'type' => 'textarea',
		),
		'published_date' => array(
			'title' => 'Published Date',
			'type' => 'datetime',
			'date_format' => 'yy-mm-dd', //optional, will default to this value
			'time_format' => 'HH:mm',    //optional, will default to this value
		),
		'status' => array(
			'type' => 'enum',
			'title' => 'Status',
			'options' => array(
				Fbf\LaravelBlog\Post::DRAFT => 'Draft',
				Fbf\LaravelBlog\Post::APPROVED => 'Approved',
			),
		),
		'created_at' => array(
			'title' => 'Created',
			'type' => 'datetime',
			'editable' => false,
		),
		'updated_at' => array(
			'title' => 'Updated',
			'type' => 'datetime',
			'editable' => false,
		),
	),

	/**
	 * The filter fields
	 *
	 * @type array
	 */
	'filters' => array(
		'title' => array(
			'title' => 'Title',
		),
		'summary' => array(
			'type' => 'text',
			'title' => 'Summary',
		),
		'content' => array(
			'type' => 'text',
			'title' => 'Content',
		),
		'published_date' => array(
			'title' => 'Published Date',
			'type' => 'date',
		),
		'status' => array(
			'type' => 'enum',
			'title' => 'Status',
			'options' => array(
				Fbf\LaravelBlog\Post::DRAFT => 'Draft',
				Fbf\LaravelBlog\Post::APPROVED => 'Approved',
			),
		),
	),

	/**
	 * The width of the model's edit form
	 *
	 * @type int
	 */
	'form_width' => 500,

	/**
	 * The validation rules for the form, based on the Laravel validation class
	 *
	 * @type array
	 */
	'rules' => array(
		'title' => 'required|max:255',
		'main_image' => 'max:255',
		'main_image_alt' => 'max:255',
		'you_tube_video_id' => 'max:255',
		'status' => 'required|in:'.Fbf\LaravelBlog\Post::DRAFT.','.Fbf\LaravelBlog\Post::APPROVED,
		'published_date' => 'required|date_format:"Y-m-d H:i:s"|date',
	),

	/**
	 * The sort options for a model
	 *
	 * @type array
	 */
	'sort' => array(
		'field' => 'updated_at',
		'direction' => 'desc',
	),

	/**
	 * If provided, this is run to construct the front-end link for your model
	 *
	 * @type function
	 */
	'link' => function($model)
		{
			return $model->getUrl();
		},

);