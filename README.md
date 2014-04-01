Laravel Blog
============

A Laravel 4 package to add a simple blog to a site

## Features

* Paginated index view with configurable results per page
* Year/Month archive filtering, including an archive partial that you can include in your own views (requires MySQL)
* Draft/Approved status and published date fields for approvals and scheduled publishing of posts
* Configurable URLs, e.g. /blog or /news/yyyy/mm or /articles/< article slug >
* Fields for title, slug, main image or YouTube Video ID, summary, content, link text and url for external links, is sticky?, published date, status, meta description and keywords, in RSS?
* Faker seed to seed your blog with loads of good test data
* Administrator config file for use with FrozenNode's Administrator package
* Bundled migration for building the database schema
* Extendable to add categories or tags relationships and filter by them, see below
*

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

The package views declare several sections that you may want to `yield` in your `app/views/layouts/master.blade.php` file, e.g.:

```html
<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta name="description" content="@yield('meta_description')">
	<meta name="keywords" content="@yield('meta_keywords')">
</head>
<body>
<div class="content">
	@yield('content')
</div>
</body>
</html>
```

The package's views are actually really simple, and most of the presentation is done in partials. This is deliberate so you
 can override the package's views in your own app, so you can include your own chrome, navigation and sidebars etc, yet
 you can also still make use of the partials provided, if you want to.

To override any view in your own app, just create the following directories and copy the file from the package into it, then hack away
* `app/views/packages/fbf/laravel-blog/posts`
* `app/views/packages/fbf/laravel-blog/partials`

## Extending the package

This can be done for the purposes of say, relating the Post model to a Category model and allowing filtering by category,
 or relating the Post model to a User model to add and Author to a Post, or simply just for overriding the functionality
 in the bundled Post model.

### Basic approach

(See the example below for more specific information.)

To override the `Post` model in the package, create a model in you app/models directory that extends the package model.

Finally, update the IoC Container to inject an instance of your model into the `Fbf\LaravelBlog\PostsController`,
instead of the package's model, e.g. in `app/start/global.php`

```php
App::bind('Fbf\LaravelBlog\PostsController', function() {
    return new Fbf\LaravelBlog\PostsController(new Post);
});
```

To achieve adding a relationship and then filtering by that relationship, this involves extending the `Post` model to
add the relationship method that you want, to another existing model in your app, and overriding the
`Post::indexByRelationship()` method.

In addition, you'll need to create a link between the Post model and the related model. Depending on whether you are going for
a `belongsTo` relationship or a `belongsToMany` relationship, this will either involve adding a field to the `fbf_posts`
table, e.g. `category_id` or creating a many-to-many join table between the `fbf_posts` table and the related model's
table, e.g. `post_tag`. So create a migration for this and run it.

If you are using FrozenNode's Administrator package, update the `app/config/administrator/posts.php` config file to use
your new model e.g. `Post` instead of `Fbf\LaravelBlog\Post`, and add the field to the `edit_fields` section to allow
you to attach the Post to the related model.

Finally you need to enable the filter by relationship route. In the package's routes config file in `src/config/routes.php`
change the `'relationship_uri_prefix'` value from false to the string you'd like to use in the URL, after the base part,
and before the 'relationship identifier'. For example, if you want your URLs to be `http://domain.com/posts/tagged/my-tag`
change the `'relationship_uri_prefix'` value to be `'tagged'`.

### Example for Post belongsToMany Categories (hierarchical)

This is a sample model class that demonstrates how you can add a many to many relationship to the Post model and
allow filtering of posts by an item in the related model. This example relates the Post model to a Category model
in the `fbf/laravel-categories` package, which is a hierarchy, so this not only allows you to filter posts to those
assigned to a selected category, but to filter them by the selected category and/or any of it's children.

To implement as is, create a file in `app/models/Post.php`, and copy this code into it

```php
<?php

use Fbf\LaravelCategories\Category;

class Post extends Fbf\LaravelBlog\Post {

	/**
	 * Defines the belongsToMany relationship between Post and Category
	 *
	 * @return mixed
	 */
	public function categories()
	{
		return $this->belongsToMany('Fbf\LaravelCategories\Category', 'category_post');
	}

	/**
	 * Query scope to filter posts by a given category
	 *
	 * @param $query
	 * @param $categorySlug
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	public function scopeByRelationship($query, $categorySlug)
	{
		$category = Category::live()
			->where('slug', '=', $categorySlug)
			->first();

		if (!$category)
		{
			throw new InvalidArgumentException('Category not found');
		}

		return $query->join('category_post', $this->getTable().'.id', '=', 'category_post.post_id')
			->join('fbf_categories', 'category_post.category_id', '=', 'fbf_categories.id')
			->whereBetween('fbf_categories.lft', array($category->lft, $category->rgt))
			->groupBy($this->getTable().'.id');
	}

}
```

Here is a sample migration to link Posts to Categories. Create a migration called `2014_02_25_154025_link_posts_categories.php`
and paste this code into it, then run the migration.

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkPostsCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_post', function(Blueprint $table)
		{
			$table->integer('category_id');
			$table->integer('post_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_post');
	}

}
```

If you are using FrozenNode's Administrator package, update the `app/config/administrator/posts.php` config file to use
your new model e.g. `Post` instead of `Fbf\LaravelBlog\Post`, and add the field to the `edit_fields` section to allow
you to attach the Post to the related model.

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
		'categories' => array(
			'title' => 'Categories',
			'type' => 'relationship',
			'name_field' => 'path',
			'options_sort_field' => 'name',
		),
```

As mentioned above, update the IoC Container to inject an instance of your model into the `Fbf\LaravelBlog\PostsController`,
instead of the package's model, e.g. in `app/start/global.php`

```php
App::bind('Fbf\LaravelBlog\PostsController', function() {
    return new Fbf\LaravelBlog\PostsController(new Post);
});
```

Finally you need to enable the 'filter by relationship' route. In the package's routes config file in `src/config/routes.php`
change the `'relationship_uri_prefix'` value from false to `'category'`.

Once you've created some categories and assigned some posts to them, you can filter the posts by visiting a URL like
`http://domain.com/blog/category/my-category`.

### Need comments?

Have a look at https://github.com/FbF/Laravel-Comments