@if (Config::get('laravel-blog::show_archives_on_view') and !empty($archives))
	<ul class="blog-archives">
		@foreach ($archives as $year => $months)
		<li>{{ $year }}
			<ul>
				@foreach ($months as $monthNumber => $month)
				<li><a href="/{{ Config::get('laravel-blog::uri') }}/{{ $year }}/{{ $monthNumber }}">{{ $month['monthname'] }} ({{ $month['count'] }})</a></li>
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul>
@endif
