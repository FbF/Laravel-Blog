<div class="blog blog__details">
    
    <div class="blog--post">

        <div class="blog--post--inner">

        	<h2 class="blog--title">{{ $post->title }}</h2>

        	@if (Config::get('laravel-blog::show_share_partial_on_view'))
        		@include('laravel-blog::partials.share')
        	@endif

        	<p class="blog--date">
        		{{ date(Config::get('laravel-blog::published_date_format'), strtotime($post->published_date)) }}
        	</p>

        	@if (!empty($post->you_tube_video_id))
        		{{ $post->getYouTubeEmbedCode() }}
        	@elseif (!empty($post->image))
        		{{ $post->getDetailsImage() }}
        	@endif

        	{{ $post->content }}

        	<p class="blog--back">
        		<a href="{{ action('Fbf\LaravelBlog\PostsController@index') }}">
        			{{ trans('laravel-blog::messages.details.back_link_text') }}
        		</a>
        	</p>
    	
    	</div>

    </div>



    @if (Config::get('laravel-blog::show_adjacent_posts_on_view') && ($newer || $older))

    	<div class="blog--adjacent-posts">

    		@if ($newer)
    			<a href="{{ $newer->getUrl() }}" class="blog--prev-post">{{ trans('laravel-blog::messages.details.newer_link_text', array('title' => $newer->title)) }}</a>
    		@endif

    		@if ($older)
    			<a href="{{ $older->getUrl() }}" class="blog--next-post">{{ trans('laravel-blog::messages.details.older_link_text', array('title' => $older->title)) }}</a>
    		@endif

    	</div>

    @endif

</div>