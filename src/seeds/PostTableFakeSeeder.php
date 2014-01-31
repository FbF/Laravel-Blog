<?php namespace Fbf\LaravelBlog;

class PostTableFakeSeeder extends \Seeder {

	public function run()
	{
		$replace = \Config::get('laravel-blog::seed.replace');
		if ($replace)
		{
			\DB::table('fbf_blog_posts')->delete();
		}

		$faker = \Faker\Factory::create();

		$statuses = array(
			Post::DRAFT,
			Post::APPROVED
		);

		for ($i = 0; $i < 100; $i++)
		{
			$post = new Post();
			$title = $faker->sentence(rand(1, 10));
			$post->title = $title;
			$youTubeVideoFreq = \Config::get('laravel-blog::seed.you_tube_video_freq');
			$hasYouTubeVideos = $youTubeVideoFreq > 0 && rand(1, $youTubeVideoFreq) == $youTubeVideoFreq;
			if ($hasYouTubeVideos)
			{
				$post->you_tube_video_id = $faker->randomElement(\Config::get('laravel-blog::seed.you_tube_video_ids'));
				$post->image = $post->image_alt = '';
			}
			else
			{
				$post->you_tube_video_id = '';
				$imageFreq = \Config::get('laravel-blog::seed.image_freq');
				$hasImage = $imageFreq > 0 && rand(1, $imageFreq) == $imageFreq;
				if ($hasImage)
				{
					$thumbnail = $faker->image(
						public_path(\Config::get('laravel-blog::thumbnails_image_dir')),
						\Config::get('laravel-blog::thumbnail_image_width'),
						\Config::get('laravel-blog::thumbnail_image_height')
					);
					$filename = basename($thumbnail);
					$details = $faker->image(
						public_path(\Config::get('laravel-blog::details_image_dir')),
						rand(200, \Config::get('laravel-blog::details_image_max_width')),
						rand(200, \Config::get('laravel-blog::details_image_max_height'))
					);
					rename($details, public_path(\Config::get('laravel-blog::details_image_dir')) . $filename);
					$post->image = $filename;
					$post->image_alt = $title;
				}
				else
				{
					$post->image = $post->image_alt = '';
				}
			}
			$summary = $faker->paragraph(rand(1, 4));
			$post->summary = $summary;
			$post->content = '<p>'.implode('</p><p>', $faker->paragraphs(rand(1, 10))).'</p>';
			$post->in_rss = (bool) rand(0, 1);
			$post->meta_description = $summary;
			$post->meta_keywords = $faker->words(10, true);
			$post->status = $faker->randomElement($statuses);
			$post->published_date = $faker->dateTimeBetween('-3 years', '+1 month');
			$post->save();
		}
		echo 'Database seeded' . PHP_EOL;
	}
}