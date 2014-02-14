@if (Config::get('laravel-blog::show_archives_on_view') and !empty($archives))
	<ul class="blog-archives">
		@foreach ($archives as $year => $months)
			<li class="blog-archives--year{{ isset($selectedYear) && $year == $selectedYear ? ' blog-archives--year__selected' : '' }}">{{ $year }}
				<ul>
					@foreach ($months as $monthNumber => $month)
						<li class="blog-archives--month{{ isset($selectedYear) && $year == $selectedYear && isset($selectedMonth) && $monthNumber == $selectedMonth ? ' blog-archives--month__selected' : '' }}">
							<a href="/{{ Config::get('laravel-blog::uri') }}/{{ $year }}/{{ $monthNumber }}">
								{{ $month['monthname'] }} ({{ $month['count'] }})
							</a>
						</li>
					@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
@endif
