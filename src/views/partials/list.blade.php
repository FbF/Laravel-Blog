@if (!$posts->isEmpty())

	@foreach ($posts as $post)

		<div class="post">

			<h2>
				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
					{{ $post->title }}
				</a>
			</h2>

			<p class="date">
				{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
			</p>

			@if (!empty($post->you_tube_video_id))
				<div class="posts-index-youtube-thumb">
					<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
						{{ $post->getYouTubeThumbnailImage() }}
					</a>
				</div>
			@elseif (!empty($post->image))
				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
					{{ $post->getThumbnailImage() }}
				</a>
			@endif

			<p>{{ $post->summary }}</p>

			<p>
				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
					{{ trans('laravel-blog::messages.list.more_link_text') }}
				</a>
			</p>

		</div>

	@endforeach

	{{ $posts->links() }}

@else

	<p>
		{{ trans('laravel-blog::messages.list.no_posts') }}
	</p>

@endif