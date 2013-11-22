<div class="post">

	<h2>{{ $post->title }}</h2>

	<p class="date">
		{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
	</p>

	@if (!empty($post->you_tube_video_id))
		{{
			str_replace('%YOU_TUBE_VIDEO_ID%', $post->you_tube_video_id,
				Config::get('laravel-blog::you_tube_embed_code'))
		}}
	@elseif (!empty($post->image))
		<img src="{{ Config::get('laravel-blog::details_image_dir') }}{{ $post->image }}" alt="{{ $post->title }}" width="{{ $post->image_width }}" height="{{ $post->image_height }}" />
	@endif

	{{ $post->content }}

</div>



@if (Config::get('laravel-blog::show_adjacent_posts_on_view') && ($newer || $older))

	<div class="adjacent-posts">

		@if ($newer)
			<a href="{{ $newer->getUrl() }}" class="prev-post">{{ $newer->title }}</a>
		@endif

		@if ($older)
			<a href="{{ $older->getUrl() }}" class="next-post">{{ $older->title }}</a>
		@endif

	</div>

@endif