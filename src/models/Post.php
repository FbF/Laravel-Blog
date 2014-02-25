<?php namespace Fbf\LaravelBlog;

class Post extends \Eloquent {

	/**
	 * Status values for the database
	 */
	const DRAFT = 'DRAFT';
	const APPROVED = 'APPROVED';

	/**
	 * Name of the table to use for this model
	 * @var string
	 */
	protected $table = 'fbf_blog_posts';

	/**
	 * Used for Cviebrock/EloquentSluggable
	 * @var array
	 */
	public static $sluggable = array(
		'build_from' => 'title',
		'save_to' => 'slug',
		'separator' => '-',
		'unique' => true,
		'include_trashed' => true,
	);

	/**
	 * Query scope for "live" posts, adds conditions for status = APPROVED and published date is in the past
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeLive($query)
	{
		return $query->where('status', '=', Post::APPROVED)
			->where('published_date', '<=', \Carbon\Carbon::now());
	}

	/**
	 * Query scope for posts published within the given year and month number.
	 *
	 * @param $query
	 * @param $year
	 * @param $month
	 * @return mixed
	 */
	public function scopeByYearMonth($query, $year, $month)
	{
		return $query->where(\DB::raw('DATE_FORMAT(published_date, "%Y%m")'), '=', $year.$month);
	}

	/**
	 * Returns a formatted multi-dimensional array, indexed by year and month number, each with an array with keys for
	 * 'month name' and the count / number of items in that month. For example:
	 *
	 *      array(
	 *          2014 => array(
	 *              01 => array(
	 *                  'monthname' => 'January',
	 *                  'count' => 4,
	 *              ),
	 *              02 => array(
	 *                  'monthname' => 'February',
	 *                  'count' => 3,
	 *              ),
	 *          )
	 *      )
	 *
	 * @return array
	 */
	public static function archives()
	{
		// Get the data
		$archives = self::live()
			->select(\DB::raw('
				date(`published_date`, "%Y") AS `year`,
				date(`published_date`, "%m") AS `month`,
				date(`published_date`) AS `monthname`,
				COUNT(*) AS `count`
			'))
			->groupBy(\DB::raw('date(`published_date`, "%Y%m")'))
			->orderBy('published_date', 'desc')
			->get();

		// Convert it to a nicely formatted array so we can easily render the view
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

	/**
	 * Returns the HTML img tag for the requested image type and size for this item
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImage($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$html = '<img src="' . $this->getImageSrc($type, $size) . '"';
		$html .= ' alt="' . $this->{$type.'_alt'} . '"';
		$html .= ' width="' . $this->getImageWidth($type, $size) . '"';
		$html .= ' height="' . $this->getImageWidth($type, $size) . '" />';
		return $html;
	}

	/**
	 * Returns the value for use in the src attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageSrc($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		return self::getImageConfig($type, $size, 'dir') . $this->$type;
	}

	/**
	 * Returns the value for use in the width attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageWidth($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$method = self::getImageConfig($type, $size, 'method');

		// Width varies for images that are 'portrait', 'auto', 'fit', 'crop'
		if (in_array($method, array('portrait', 'auto', 'fit', 'crop')))
		{
			list($width) = $this->getImageDimensions($type, $size);
			return $width;
		}
		return self::getImageConfig($type, $size, 'width');
	}

	/**
	 * Returns the value for use in the height attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageHeight($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$method = self::getImageConfig($type, $size, 'method');

		// Height varies for images that are 'landscape', 'auto', 'fit', 'crop'
		if (in_array($method, array('landscape', 'auto', 'fit', 'crop')))
		{
			list($width, $height) = $this->getImageDimensions($type, $size);
			return $height;
		}
		return self::getImageConfig($type, $size, 'height');
	}

	/**
	 * Returns an array of the width and height of the current instance's image $type and $size
	 *
	 * @param $type
	 * @param $size
	 * @return array
	 */
	protected function getImageDimensions($type, $size)
	{
		$pathToImage = public_path(self::getImageConfig($type, $size, 'dir') . $this->$type);
		if (is_file($pathToImage) && file_exists($pathToImage))
		{
			list($width, $height) = getimagesize($pathToImage);
		}
		else
		{
			$width = $height = false;
		}
		return array($width, $height);
	}

	/**
	 * Returns the config setting for an image
	 *
	 * @param $imageType
	 * @param $size
	 * @param $property
	 * @internal param $type
	 * @return mixed
	 */
	public static function getImageConfig($imageType, $size, $property)
	{
		$config = 'laravel-blog::images.' . $imageType . '.';
		if ($size == 'original')
		{
			$config .= 'original.';
		}
		elseif (!is_null($size))
		{
			$config .= 'sizes.' . $size . '.';
		}
		$config .= $property;
		return \Config::get($config);
	}

	/**
	 * Returns the thumbnail image code defined in the config, for the current item's you tube video id
	 *
	 * @return string
	 */
	public function getYouTubeThumbnailImage()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get('laravel-blog::you_tube.thumbnail_code'));
	}

	/**
	 * Returns the embed code defined in the config, for the current item's you tube video id
	 *
	 * @return string
	 */
	public function getYouTubeEmbedCode()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get('laravel-blog::you_tube.embed_code'));
	}

	/**
	 * Returns the published date formatted according to the config setting
	 * @return string
	 */
	public function getDate()
	{
		return date(\Config::get('laravel-blog::views.published_date_format'), strtotime($this->published_date));
	}

	/**
	 * Returns the URL of the post
	 * @return string
	 */
	public function getUrl()
	{
		return \URL::action('Fbf\LaravelBlog\PostsController@view', array('slug' => $this->slug));
	}

	/**
	 * Returns the next newer post, relative to the current one, if it exists
	 * @return mixed
	 */
	public function newer()
	{
		return $this->live()
			->where('published_date', '>=', $this->published_date)
			->where('id', '<>', $this->id)
			->orderBy('published_date', 'asc')
			->orderBy('id', 'asc')
			->first();
	}

	/**
	 * Returns the next older post, relative to the current one, if it exists
	 * @return mixed
	 */
	public function older()
	{
		return $this->live()
			->where('published_date', '<=', $this->published_date)
			->where('id', '<>', $this->id)
			->orderBy('published_date', 'desc')
			->orderBy('id', 'desc')
			->first();
	}

}
