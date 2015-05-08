<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_cats', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('cat_name',60)->default('');
            $table->string('cat_brief')->default('');
            $table->integer('parent_id')->default(0);
            $table->string('image',90)->default('');
            $table->string('keywords')->default('');
            $table->tinyInteger('show_in_nav')->default(0);
            $table->tinyInteger('list_order')->default(0);
            $table->tinyInteger('is_show')->default(1);
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
		Schema::drop('article_cats');
	}

}
