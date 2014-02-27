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
            $table->string('main_image')->nullable();
	        $table->string('main_image_alt')->nullable();
	        $table->string('you_tube_video_id')->nullable();
            $table->text('summary');
            $table->text('content');
	        $table->string('link_text')->nullable();
	        $table->string('link_url')->nullable();
	        $table->boolean('in_rss');
	        $table->boolean('is_sticky');
	        $table->string('slug')->unique();
	        $table->string('page_title');
	        $table->text('meta_description');
	        $table->text('meta_keywords');
            $table->enum('status', array('DRAFT', 'APPROVED'))->default('DRAFT');
	        $table->dateTime('published_date')->nullable();
            $table->timestamps();
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