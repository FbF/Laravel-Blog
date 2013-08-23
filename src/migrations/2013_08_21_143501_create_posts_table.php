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
        Schema::create('fbf_simple_blog_posts', function($table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable;
            $table->text('summary');
            $table->text('content');
            $table->dateTime('published_date');
            $table->enum('status', array('DRAFT', 'APPROVED'))->default('DRAFT');
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->boolean('in_rss');
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
        Schema::drop('fbf_simple_blog_posts');
	}

}