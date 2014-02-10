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
            $table->string('image')->nullable();
	        $table->string('image_alt')->nullable();
	        $table->string('image_width')->nullable();
	        $table->string('image_height')->nullable();
	        $table->string('you_tube_video_id')->nullable();
            $table->text('summary');
            $table->text('content');
	        $table->boolean('in_rss');
	        $table->string('slug')->unique();
	        $table->text('meta_description');
	        $table->text('meta_keywords');
            $table->enum('status', array('DRAFT', 'APPROVED'))->default('DRAFT');
	        $table->dateTime('published_date')->nullable();
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