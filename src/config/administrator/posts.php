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
	'model' => 'Fbf\SimpleBlog\Post',

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
			'title' => 'Status'
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
		'image' => array(
			'title' => 'Image',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path() . '/packages/fbf/simple-blog/originals/',
			'size_limit' => 5,
			'sizes' => array(
				array(300, 200, 'crop', public_path() . '/packages/fbf/simple-blog/thumbnails/', 100),
				array(600, 400, 'crop', public_path() . '/packages/fbf/simple-blog/details/', 100),
			)
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
				Fbf\SimpleBlog\Post::DRAFT => 'Draft',
				Fbf\SimpleBlog\Post::APPROVED => 'Approved',
			),
		),
		'meta_description' => array(
			'title' => 'Meta Description',
			'type' => 'textarea',
		),
		'meta_keywords' => array(
			'title' => 'Meta Keywords',
			'type' => 'textarea',
		),
		'in_rss' => array(
			'title' => 'In RSS Feed?',
			'type' => 'bool',
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
				Fbf\SimpleBlog\Post::DRAFT => 'Draft',
				Fbf\SimpleBlog\Post::APPROVED => 'Approved',
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
		return URL::to(Config::get('simple-blog::uri').'/'.$model->slug);
	},

);