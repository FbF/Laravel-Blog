<div class="blog blog__list">

    @if (!$posts->isEmpty())

    	@foreach ($posts as $post)

    		<div class="blog--post">
    		    
    		    <div class="blog--post--inner">

        			<h2 class="blog--title">
        				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
        					{{ $post->title }}
        				</a>
        			</h2>

        			<p class="blog--date">
        				{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
        			</p>

        			@if (!empty($post->you_tube_video_id))
        				<div class="blog--youtube-thumb">
        					<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
        						{{ $post->getYouTubeThumbnailImage() }}
        					</a>
        				</div>
        			@elseif (!empty($post->image))
        			    <div class="blog--image-thumb">
            				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
            					{{ $post->getThumbnailImage() }}
            				</a>
        				</div>
        			@endif

        			<p>{{ $post->summary }}</p>

        			<p class="blog--view-more">
        				<a href="{{ $post->getUrl() }}" title="{{ $post->title }}">
        					{{ trans('laravel-blog::messages.list.more_link_text') }}
        				</a>
        			</p>
    			</div>

    		</div>

    	@endforeach

    	{{ $posts->links() }}

    @else

    	<p class="blog--empty">
    		{{ trans('laravel-blog::messages.list.no_posts') }}
    	</p>

    @endif
    
</div>