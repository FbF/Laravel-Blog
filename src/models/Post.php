<?php namespace Fbf\SimpleBlog;

use Eloquent;

class Post extends Eloquent {

	const DRAFT = 'DRAFT';

	const APPROVED = 'APPROVED';

	protected $table = 'fbf_simple_blog_posts';

	public static $sluggable = array(
		'build_from' => 'title',
		'save_to' => 'slug',
		'unique' => true,
	);

	public function scopeLive($query)
	{
		return $query->where('status', '=', Post::APPROVED)
			->where('published_date', '<=', date('Y-m-d'));
	}

	public static function archives()
	{
		$archives = self::live()
			->select(\DB::raw('
				YEAR(`published_date`) AS `year`,
				DATE_FORMAT(`published_date`, "%m") AS `month`,
				MONTHNAME(`published_date`) AS `monthname`,
				COUNT(*) AS `count`
			'))
			->groupBy(\DB::raw('DATE_FORMAT(`published_date`, "%Y%m")'))
			->orderBy('published_date', 'desc')
			->get();
		$results = array();
		foreach ($archives as $archive)
		{
			$results[$archive->year][$archive->month] = array(
				'monthname' => $archive->monthname,
				'count' => $archive->count,
			);
		}
		return $results;
	}


}