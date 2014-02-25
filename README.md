Laravel Blog
============

A Laravel 4 package to add a simple blog to a site

## Features

* Paginated index view with configurable results per page
* Year/Month archive filtering, including an archive partial that you can include in your own views (requires MySQL)
* Draft/Approved status and published date fields for approvals and scheduled publishing of posts
* Configurable URLs, e.g. /blog or /news/yyyy/mm or /articles/< article slug >
* Fields for title, slug, main image or YouTube Video ID, summary, content, published date, status, meta description and keywords, in RSS?
* Faker seed to seed your blog with loads of good test data
* Administrator config file for use with FrozenNode's Administrator package
* Bundled migration for building the database schema

## Installation

Add the following to you composer.json file (Recommend swapping "dev-master" for the latest release)

    "fbf/laravel-blog": "dev-master"

Run

    composer update

Add the following to app/config/app.php

    'Fbf\LaravelBlog\LaravelBlogServiceProvider'

Run the package migration

    php artisan migrate --package=fbf/laravel-blog

Publish the config

    php artisan config:publish fbf/laravel-blog

Optionally tweak the settings in the many config files for your app

Optionally copy the administrator config file (`src/config/administrator/posts.php`) to your administrator model config directory.

Create the relevant image upload directories that you specify in your config, e.g.

    public/uploads/packages/fbf/laravel-blog/main_image/original
    public/uploads/packages/fbf/laravel-blog/main_image/thumbnail
    public/uploads/packages/fbf/laravel-blog/main_image/resized

## Faker seed

The package comes with a seed that can populate the table with a whole bunch of sample posts. There are some configuration options for the seed in the config file. To run it:

    php artisan db:seed --class="Fbf\LaravelBlog\PostTableFakeSeeder"

## Configuration

See the many configuration options in the files in the config directory

## Administrator

You can use the excellent Laravel Administrator package by FrozenNode to administer your blog.

http://administrator.frozennode.com/docs/installation

A ready-to-use model config file for the Post model (posts.php) is provided in the src/config/administrator directory of the package, which you can copy into the app/config/administrator directory (or whatever you set as the model_config_path in the administrator config file).

## Usage

The package should work out the box (provided you have a master blade layout file, since the out-of-the-box views extend this)
 but if you want to add other content to the pages, such as your own header, logo, navigation, sidebar etc, you'll want to
 override the views provided.

The package's views are actually really simple, and most of the presentation is done in partials. This is deliberate so you
 can override the package's views in your own app, so you can include your own chrome, navigation and sidebars etc, yet
 you can also still make use of the partials provided, if you want to.

To override any view in your own app, just create the following directories and copy the file from the package into it, then hack away
* `app/views/packages/fbf/laravel-blog/posts`
* `app/views/packages/fbf/laravel-blog/partials`

## Extending the Post model

Let's say each post in your site can have a testimonial on it.

* After installing the package you can create the testimonials table and model etc (or use the fbf/laravel-testimonials package)
* Create the migration to add a testimonial_id field to the fbf_blog_posts table, and run it

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkPostsToTestimonials extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fbf_blog_posts', function(Blueprint $table)
		{
			$table->integer('testimonial_id')->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fbf_blog_posts', function(Blueprint $table)
		{
			$table->dropColumn('testimonial_id');
		});
	}

}
```

* Create a model in you app/models directory that extends the package model and includes the relationship

```php
<?php

class Post extends Fbf\LaravelBlog\Post {

	public function testimonial()
	{
		return $this->belongsTo('Fbf\LaravelTestimonials\Testimonial');
	}

}
```

* If you are using FrozenNode's Administrator package, update the posts config file to use your new model, and to allow selecting the testimonial to attach to the page:

```php
	/**
	 * The class name of the Eloquent model that this config represents
	 *
	 * @type string
	 */
	'model' => 'Post',
```
...
```php
		'testimonial' => array(
			'title' => 'Testimonial',
			'type' => 'relationship',
			'name_field' => 'title',
		),
```

* Finally, update the IoC Container to inject an instance of your model into the controller, instead of the package's model, e.g. in `app/start/global.php`

```php
App::bind('Fbf\LaravelBlog\PostsController', function() {
    return new Fbf\LaravelBlog\PostsController(new Post);
});
```