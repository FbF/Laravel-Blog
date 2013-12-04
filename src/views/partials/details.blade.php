<div class="post">

	<h2>{{ $post->title }}</h2>

	@if (Config::get('laravel-blog::show_share_partial_on_view'))
		@include('laravel-blog::partials.share')
	@endif

	<p class="date">
		{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
	</p>

	@if (!empty($post->you_tube_video_id))
		{{ $post->getYouTubeEmbedCode() }}
	@elseif (!empty($post->image))
		{{ $post->getDetailsImage() }}
	@endif

	{{ $post->content }}

	<p class="back">
		<a href="{{ action('Fbf\LaravelBlog\PostsController@index') }}">
			{{ trans('laravel-blog::messages.details.back_link_text') }}
		</a>
	</p>

</div>



@if (Config::get('laravel-blog::show_adjacent_posts_on_view') && ($newer || $older))

	<div class="adjacent-posts">

		@if ($newer)
			<a href="{{ $newer->getUrl() }}" class="prev-post">{{ trans('laravel-blog::messages.details.newer_link_text', array('title' => $newer->title)) }}</a>
		@endif

		@if ($older)
			<a href="{{ $older->getUrl() }}" class="next-post">{{ trans('laravel-blog::messages.details.older_link_text', array('title' => $older->title)) }}</a>
		@endif

	</div>

@endif