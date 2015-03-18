<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBlogNestedSet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fbf_blog_posts', function ($table) {
            $table->integer('parent_id')->nullable();
			$table->integer('lft')->nullable();
			$table->integer('rgt')->nullable();
			$table->integer('depth')->nullable();

            $table->integer('language_id')->nullable();
            $table->integer('status_id')->nullable();

			$table->index('parent_id');
			$table->index('lft');
			$table->index('rgt');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fbf_blog_posts', function ($table) {
            $table->dropColumn('parent_id')->nullable();
			$table->dropColumn('lft')->nullable();
			$table->dropColumn('rgt')->nullable();
			$table->dropColumn('depth')->nullable();

            $table->dropColumn('language_id')->nullable();
            $table->dropColumn('status_id')->nullable();

			$table->dropIndex('parent_id');
			$table->dropIndex('lft');
			$table->dropIndex('rgt');
        });
	}
}
