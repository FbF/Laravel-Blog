<div class="item">

	<p class="item--all-link">
		<a href="{{ action('Fbf\LaravelBlog\PostsController@index') }}">
			{{ trans('laravel-blog::messages.details.all_link_text') }}
		</a>
	</p>

	<h2 class="item--title">
		{{ $post->title }}
	</h2>

	<p class="item--date">
		{{ $post->getDate() }}
	</p>

	<div class="item--summary">
		{{ $post->summary }}
	</div>

	@if (Config::get('laravel-blog::views.view_page.show_share_partial'))
		@include('laravel-blog::partials.share')
	@endif

	@if (!empty($post->you_tube_video_id))
		<div class="item--media item--media__youtube">
			{{ $post->getYouTubeEmbedCode() }}
		</div>
	@elseif (!empty($post->main_image))
		<div class="item--media item--media__image">
			{{ $post->getImage('main_image', 'resized') }}
		</div>
	@endif

	{{ $post->content }}

</div>

@if (Config::get('laravel-blog::views.view_page.show_adjacent_items') && ($newer || $older))
	@include('laravel-blog::partials.adjacent')
@endif