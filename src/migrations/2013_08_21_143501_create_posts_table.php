<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('fbf_blog_posts', function($table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('image');
	        $table->string('image_alt');
	        $table->string('image_width');
	        $table->string('image_height');
	        $table->string('you_tube_video_id');
            $table->text('summary');
            $table->text('content');
	        $table->boolean('in_rss');
	        $table->string('slug')->unique();
	        $table->text('meta_description');
	        $table->text('meta_keywords');
            $table->enum('status', array('DRAFT', 'APPROVED'))->default('DRAFT');
	        $table->dateTime('published_date');
            $table->timestamps();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('fbf_blog_posts');
	}

}