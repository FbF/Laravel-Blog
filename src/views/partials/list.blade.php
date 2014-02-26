<div class="item-list">

	@if (!$posts->isEmpty())

		@foreach ($posts as $post)
	
			<div class="item{{ $post->is_sticky ? ' item__sticky' : '' }}">
		
				<h2 class="item--title">
					<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
						{{ $post->title }}
					</a>
				</h2>
		
				<p class="item--date">
					{{ $post->getDate() }}
				</p>
		
				@if (!empty($post->you_tube_video_id))
					<div class="item--thumb item--thumb__youtube">
						<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
							{{ $post->getYouTubeThumbnailImage() }}
						</a>
					</div>
				@elseif (!empty($post->main_image))
					<div class="item--thumb item--thumb__image">
						<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
							{{ $post->getImage('main_image', 'thumbnail') }}
						</a>
					</div>
				@endif
		
				<div class="item--summary">
					{{ $post->summary }}
				</div>
		
				<p class="item--more-link">
					<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
						{{ trans('laravel-blog::messages.list.more_link_text') }}
					</a>
				</p>
		
			</div>
	
		@endforeach

		{{ $posts->links() }}

	@else

		<p class="item-list--empty">
			{{ trans('laravel-blog::messages.list.no_items') }}
		</p>

	@endif

</div>