<div class="share-buttons">
	<p>{{ trans('laravel-blog::messages.share.label') }}</p>
	<p class="share-button share-button__twitter">
		<a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title . ' ' . $post->getUrl()) }}" target="_blank">
			{{ trans('laravel-blog::messages.share.twitter') }}
		</a>
	</p>
	<p class="share-button share-button__facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->getUrl()) }}" target="_blank">
			{{ trans('laravel-blog::messages.share.facebook') }}
		</a>
	</p>
</div>