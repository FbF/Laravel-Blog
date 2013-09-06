@extends('simple-blog::layouts.master')

@section('title')
	{{ $post->title }}
@endsection

@section('meta_description')
	{{ $post->meta_description }}
@endsection

@section('meta_keywords')
	{{ $post->meta_keywords }}
@endsection

@section('content')
	<div class="post">
		<h2>{{ $post->title }}</h2>
		<p class="date">{{ date(Config::get('simple-blog::published_date_format'), strtotime($post->published_date)) }}</p>
		@if (!empty($post->image))
			<img src="/packages/fbf/simple-blog/details/{{ $post->image }}" alt="{{ $post->title }}" width="600" height="400" />
		@endif
		{{ $post->content }}
	</div>

	@if (Config::get('simple-blog::show_adjacent_posts_on_view') and ($newer or $older))
	<div class="adjacent-posts">
		@if ($newer)
			<a href="/{{ Config::get('simple-blog::uri') }}/{{ $newer->slug }}" class="prev-post">{{ $newer->title }}</a>
		@endif
		@if ($older)
			<a href="/{{ Config::get('simple-blog::uri') }}/{{ $older->slug }}" class="next-post">{{ $older->title }}</a>
		@endif
	</div>
	@endif
@stop

@section('sidebar')
	@include('simple-blog::posts.archives', compact('archives'))
@stop