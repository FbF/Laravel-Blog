@extends('simple-blog::layouts.master')

@section('title')
	{{ Config::get('simple-blog::index_page_title') }}
@endsection

@section('meta_description')
	{{ Config::get('simple-blog::index_page_meta_description') }}
@endsection

@section('meta_keywords')
	{{ Config::get('simple-blog::index_page_meta_keywords') }}
@endsection

@section('content')
	@if (!empty($posts))
		@foreach ($posts as $post)
			<div class="post">
				<h2><a href="/{{ Config::get('simple-blog::uri') }}/{{ $post->slug }}">{{ $post->title }}</a></h2>
				<p class="date">{{ $post->published_date }}</p>
				@if (!empty($post->image))
					<img src="/uploads/fbf_simple_blog/thumbnails/{{ $post->image }}" alt="{{ $post->title }}" width="300" height="200" />
				@endif
				<p>{{ $post->summary }}</p>
			</div>
		@endforeach
		{{ $posts->links() }}
	@else
		<p>There aren't any posts at the moment.</p>
	@endif
@stop

@section('sidebar')
	@include('simple-blog::posts.archives', compact('archives'))
@stop