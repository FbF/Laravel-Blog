<div class="blog--share">
	<p>{{ trans('laravel-blog::messages.details.share_label') }}</p>
	<p class="blog--share--twitter">
		<a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title . ' ' . $post->getUrl()) }}" target="_blank">
			Share on Twitter
		</a>
	</p>
	<p class="blog--share--facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->getUrl()) }}" target="_blank">
			Share on Facebook
		</a>
	</p>
</div>