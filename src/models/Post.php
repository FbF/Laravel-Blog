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
	 * @var bool
	 */
	protected $softDelete = true;

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
	 * Used to store the old image value, set during model updating event before the model is actually updated
	 * Used to compare with the new main image value after saving the model, so we can work out whether we need to
	 * recalculate the image width and height
	 * @var string
	 */
	protected $oldImage = null;

	/**
	 *
	 */
	public static function boot()
	{
		parent::boot();

		static::created(function($post)
		{
			// If the record is being created and there is an "image" supplied, set it's width and height
			if (!empty($post->image))
			{
				$post->updateImageSize();
			}
		});

		static::updating(function($post)
		{
			// If the record is about to be updated and there is a "image" supplied, get the current image
			// value so we can compare it to the new one
			$post->oldImage = self::where('id','=',$post->id)->first()->pluck('image');
			return true;
		});

		static::updated(function($post)
		{
			// If the main image has changed, and the save was successful, update the database with the new width and height
			if (isset($post->oldImage) && $post->oldImage <> $post->image)
			{
				$post->updateImageSize();
			}
		});

	}

	/**
	 * Triggered from madel save events, it updates the main image width and height fields to the values of the
	 * uploaded image.
	 */
	protected function updateImageSize()
	{
		// Get path to image
		$pathToImage = public_path() . \Config::get('laravel-blog::details_image_dir') . $this->image;
		if (is_file($pathToImage) && file_exists($pathToImage))
		{
			list($width, $height) = getimagesize($pathToImage);
		}
		else
		{
			$width = $height = null;
		}
		// Update the database, use DB::table()->update approach so as not to trigger the Eloquent save() event again.
		\DB::table($this->getTable())
			->where('id', $this->id)
			->update(array(
				'image_width' => $width,
				'image_height' => $height,
			));
	}

	public function scopeLive($query)
	{
		return $query->where('status', '=', Post::APPROVED)
			->where('published_date', '<=', \Carbon\Carbon::now());
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

	/**
	 * Returns the URL of the post
	 * @return string
	 */
	public function getUrl()
	{
		return \URL::action('Fbf\LaravelBlog\PostsController@view', array('slug' => $this->slug));
	}

	/**
	 * Returns the HTML img tag for the post's thumbnail image
	 * @return null|string
	 */
	public function getThumbnailImage()
	{
		if (empty($this->image))
		{
			return null;
		}
		$html = '<img src="' . \Config::get('laravel-blog::thumbnails_image_dir') . $this->image . '"';
		$html .= ' alt="' . $this->image_alt . '"';
		$html .= ' width="' . \Config::get('laravel-blog::thumbnail_image_width') . '"';
		$html .= ' height="' . \Config::get('laravel-blog::thumbnail_image_height') . '" />';
		return $html;
	}

	/**
	 * Returns the HTML img tag for the post's details page image
	 * @return null|string
	 */
	public function getDetailsImage()
	{
		if (empty($this->image))
		{
			return null;
		}
		$html = '<img src="' .\Config::get('laravel-blog::details_image_dir') . $this->image . '"';
		$html .= ' alt="' . $this->image_alt . '"';
		$html .= ' width="' . $this->image_width . '"';
		$html .= ' height="' . $this->image_height . '">';
		return $html;
	}

	public function getYouTubeThumbnailImage()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get('laravel-blog::you_tube_thumbnail_code'));
	}

	public function getYouTubeEmbedCode()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get('laravel-blog::you_tube_embed_code'));
	}

}