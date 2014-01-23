<?php namespace Fbf\LaravelBlog;

class PostsController extends \BaseController {

	public function index($year = null, $month = null)
	{
		// Initiate query, don't paginate on it yet in case we want the year/month condition added
		$query = Post::live();

		// If year and month passed in the URL, add this condition
		if ($year && $month) {
			$query = $query->where(\DB::raw('DATE_FORMAT(published_date, "%Y%m")'), '=', $year.$month);
		}

		// Get the current page's posts
		$viewData['posts'] = $query
			->orderBy('published_date', 'desc')
			->paginate(\Config::get('laravel-blog::results_per_page'));

		// Get the archives data if the config says to show the archives on the index page
		if (\Config::get('laravel-blog::show_archives_on_index'))
		{
			$viewData['archives'] = Post::archives();
		}

		return \View::make(\Config::get('laravel-blog::index_view'), $viewData);
	}

	public function view($slug) {

		// Get the selected post
		$viewData['post'] = $post = Post::live()
			->where('slug', '=', $slug)
			->firstOrFail();

		// Get the next newest and next oldest post if the config says to show these links on the view page
		if (\Config::get('laravel-blog::show_adjacent_posts_on_view'))
		{
			$viewData['newer'] = Post::live()
				->where('published_date', '>=', $post->published_date)
				->where('id', '<>', $post->id)
				->orderBy('published_date', 'asc')
				->orderBy('id', 'asc')
				->first();

			$viewData['older'] = Post::live()
				->where('published_date', '<=', $post->published_date)
				->where('id', '<>', $post->id)
				->orderBy('published_date', 'desc')
				->orderBy('id', 'desc')
				->first();
		}

		if (\Config::get('laravel-blog::show_archives_on_view'))
		{
			$viewData['archives'] = Post::archives();
		}

		return \View::make(\Config::get('laravel-blog::view_view'), $viewData);

	}

	public function rss()
	{

		$feed = Rss::feed('2.0', 'UTF-8');
		$feed->channel(array(
			'title' => \Config::get('laravel-blog::rss_feed_title'),
			'description' => \Config::get('laravel-blog::rss_feed_description'),
			'link' => \URL::current(),
		));
		$posts = Post::where('status', '=', Post::APPROVED)
			->where('in_rss', '=', true)
			->orderBy('published_date', 'desc')
			->take(10)
			->get();
		foreach ($posts as $post){
			$feed->item(array(
				'title' => $post->title,
				'description' => $post->summary,
				'link' => \URL::to(\Config::get('laravel-blog::uri').'/'.$post->slug),
			));
		}

		return \Response::make($feed, 200, array('Content-Type', 'application/rss+xml'));

	}

}
