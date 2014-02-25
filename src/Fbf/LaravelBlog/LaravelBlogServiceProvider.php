<?php namespace Fbf\LaravelBlog;

use Illuminate\Support\ServiceProvider;

class LaravelBlogServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('fbf/laravel-blog');

		if (\Config::get('laravel-blog::routes.use_package_routes', true))
		{
			include __DIR__.'/../../routes.php';
		}

		\App::register('Thujohn\Rss\RssServiceProvider');
		\App::register('Cviebrock\EloquentSluggable\SluggableServiceProvider');

		// Shortcut so developers don't need to add an Alias in app/config/app.php
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Fbf\LaravelBlog\Rss', 'Thujohn\Rss\RssFacade');
			$loader->alias('Sluggable', 'Cviebrock\EloquentSluggable\Facades\Sluggable');
		});

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}