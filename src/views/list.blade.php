@if (!$posts->isEmpty())

	@foreach ($posts as $post)

		<div class="post">

			<h2>
				<a href="{{ $post->getUrl() }}">
					{{ $post->title }}
				</a>
			</h2>

			<p class="date">
				{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
			</p>

			@if (!empty($post->image))
				<img src="{{ Config::get('laravel-blog::thumbnails_image_dir') }}{{ $post->image }}"
				     alt="{{ $post->image_alt }}"
				     width="{{ Config::get('laravel-blog::thumbnail_image_width') }}"
				     height="{{ Config::get('laravel-blog::thumbnail_image_height') }}" />
			@endif

			<p>{{ $post->summary }}</p>

		</div>

	@endforeach

	{{ $posts->links() }}

@else

	<p>
		There aren't any posts at the moment.
	</p>

@endif