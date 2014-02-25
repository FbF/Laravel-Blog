@if (isset($archives) && !empty($archives))
	<ul class="archives">
		@foreach ($archives as $year => $months)
			<li class="archives--year{{ isset($selectedYear) && $year == $selectedYear ? ' archives--year__active' : '' }}">{{ $year }}
				<ul>
					@foreach ($months as $monthNumber => $month)
						<li class="archives--month{{ isset($selectedYear) && $year == $selectedYear && isset($selectedMonth) && $monthNumber == $selectedMonth ? ' archives--month__active' : '' }}">
							<a href="{{ action('Fbf\LaravelBlog\PostsController@index', array('year' => $year, 'month' => $monthNumber)) }}">
								{{ $month['monthname'] }} ({{ $month['count'] }})
							</a>
						</li>
					@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
@endif