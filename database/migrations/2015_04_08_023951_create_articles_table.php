<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->smallInteger('cat_id')->default(0)->unsigned();
            $table->string('title')->default('');
            $table->string('image',90);
            $table->string('slug')->default('');
            $table->text('body')->nullable();
            $table->integer('user_id')->default(0)->unsigned();
			$table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('cat_id');
            $table->foreign('cat_id')->references('id')->on('article_cats');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
