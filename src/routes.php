<?php

use Fbf\SimpleBlog\Post;

// e.g. http://domain.com/blog or http://domain.com/blog/yyyy/mm
Route::get(Config::get('simple-blog::uri').'/{year?}/{month?}', function($year, $month)
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
		->orderBy('id', 'desc')
		->paginate(Config::get('simple-blog::results_per_page'));

	// Get the archives data if the config says to show the archives on the index page
	if (Config::get('simple-blog::show_archives_on_index'))
	{
		$viewData['archives'] = Post::archives();
	}

	return View::make('simple-blog::posts.index', $viewData);

})
->where(array(
	'year' => '\d{4}',
	'month' => '\d{2}'
));

// e.g. http://domain.com/blog/my-post
Route::get(Config::get('simple-blog::uri').'/{slug}', function($slug) {

	// Get the selected post
	$viewData['post'] = $post = Post::live()
		->where('slug', '=', $slug)
		->firstOrFail();

	// Get the next newest and next oldest post if the config says to show these links on the view page
	if (Config::get('simple-blog::show_adjacent_posts_on_view'))
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

	if (Config::get('simple-blog::show_archives_on_view'))
	{
		$viewData['archives'] = Post::archives();
	}

	return View::make('simple-blog::posts.view', $viewData);

});

// e.g. http://domain.com/blog.rss
Route::get(Config::get('simple-blog::uri').'.rss', function()
{

	$feed = Rss::feed('2.0', 'UTF-8');
	$feed->channel(array(
		'title' => Config::get('simple-blog::rss_feed_title'),
		'description' => Config::get('simple-blog::rss_feed_description'),
		'link' => URL::current(),
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
			'link' => URL::to(Config::get('simple-blog::uri').'/'.$post->slug),
		));
	}

	return Response::make($feed, 200, array('Content-Type', 'application/rss+xml'));

});