<?php namespace Fbf\LaravelBlog;

class PostTableFakeSeeder extends \Seeder {

	protected $post;

	public function run()
	{
		$this->truncate();

		$this->faker = \Faker\Factory::create();

		$numberToCreate = \Config::get('laravel-blog::seed.number');

		for ($i = 0; $i < $numberToCreate; $i++)
		{
			$this->create();
		}

		echo 'Database seeded' . PHP_EOL;
	}

	protected function truncate()
	{
		$replace = \Config::get('laravel-blog::seed.replace');
		if ($replace)
		{
			\DB::table('fbf_blog_posts')->delete();
		}
	}

	protected function create()
	{
		$this->post = new Post();
		$this->setTitle();
		$this->setMedia();
		$this->setSummary();
		$this->setContent();
		$this->setLink();
		$this->setIsSticky();
		$this->setInRss();
		$this->setPageTitle();
		$this->setMetaDescription();
		$this->setMetaKeywords();
		$this->setStatus();
		$this->setPublishedDate();
		$this->post->save();
	}

	protected function setTitle()
	{
		$title = $this->faker->sentence(rand(1, 10));
		$this->post->title = $title;
	}

	protected function setMedia()
	{
		if ($this->hasYouTubeVideos())
		{
			$this->setYouTubeVideoId();
		}
		elseif ($this->hasMainImage())
		{
			$this->doMainImage();
		}
	}

	protected function hasYouTubeVideos()
	{
		$youTubeVideoFreq = \Config::get('laravel-blog::seed.you_tube.freq');
		$hasYouTubeVideos = $youTubeVideoFreq > 0 && rand(1, $youTubeVideoFreq) == $youTubeVideoFreq;
		return $hasYouTubeVideos;
	}

	protected function setYouTubeVideoId()
	{
		$this->post->you_tube_video_id = $this->faker->randomElement(\Config::get('laravel-blog::seed.you_tube.video_ids'));
	}

	protected function hasMainImage()
	{
		$mainImageFreq = \Config::get('laravel-blog::seed.images.main_image.freq');
		$hasMainImage = $mainImageFreq > 0 && rand(1, $mainImageFreq) == $mainImageFreq;
		return $hasMainImage;
	}

	protected function doMainImage()
	{
		$imageOptions = \Config::get('laravel-blog::images.main_image');
		if (!$imageOptions['show'])
		{
			return false;
		}
		$seedOptions = \Config::get('laravel-blog::seed.images.main_image');
		$original = $this->faker->image(
			public_path($imageOptions['original']['dir']),
			$seedOptions['original_width'],
			$seedOptions['original_height'],
			$seedOptions['category']
		);
		$filename = basename($original);
		foreach ($imageOptions['sizes'] as $sizeOptions)
		{
			$image = $this->faker->image(
				public_path($sizeOptions['dir']),
				$sizeOptions['width'],
				$sizeOptions['height']
			);
			rename($image, public_path($sizeOptions['dir']) . $filename);
		}
		$this->post->main_image = $filename;
		$this->post->main_image_alt = $this->post->title;
	}

	protected function setSummary()
	{
		$this->post->summary = '<p>'.implode('</p><p>', $this->faker->paragraphs(rand(1, 2))).'</p>';
	}

	protected function setContent()
	{
		$this->post->content = '<p>'.implode('</p><p>', $this->faker->paragraphs(rand(4, 10))).'</p>';
	}

	protected function setLink()
	{
		if ($this->hasLink())
		{
			$this->setLinkText();
			$this->setLinkUrl();
		}
	}

	protected function hasLink()
	{
		$showLink =  \Config::get('laravel-blog::link.show');
		if (!$showLink)
		{
			return false;
		}
		$linkFreq = \Config::get('laravel-blog::seed.link.freq');
		$hasLink = $linkFreq > 0 && rand(1, $linkFreq) == $linkFreq;
		return $hasLink;
	}

	protected function setLinkText()
	{
		$linkTexts = \Config::get('laravel-blog::seed.link.texts');
		$this->post->link_text = $this->faker->randomElement($linkTexts);
	}

	protected function setLinkUrl()
	{
		$linkUrls = \Config::get('laravel-blog::seed.link.urls');
		$this->post->link_url = $this->faker->randomElement($linkUrls);
	}

	protected function setIsSticky()
	{
		$this->post->is_sticky = (bool) rand(0, 1);
	}

	protected function setInRss()
	{
		$this->post->in_rss = (bool) rand(0, 1);
	}

	protected function setPageTitle()
	{
		$this->post->page_title = $this->post->title;
	}

	protected function setMetaDescription()
	{
		$this->post->meta_description = $this->faker->paragraph(rand(1, 2));
	}

	protected function setMetaKeywords()
	{
		$this->post->meta_keywords = $this->faker->words(10, true);
	}

	protected function setStatus()
	{
		$statuses = array(
			Post::DRAFT,
			Post::APPROVED
		);
		$this->post->status = $this->faker->randomElement($statuses);
	}

	protected function setPublishedDate()
	{
		$this->post->published_date = $this->faker->dateTimeBetween('-2 years', '+1 month')->format('Y-m-d H:i:s');
	}
}