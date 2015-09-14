<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosterThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poster_themes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->default(0)->unsigned();
            $table->integer('template_id')->default(0)->unsigned();
            $table->string('site_url')->default('');
            $table->tinyInteger('status')->default(0);
            $table->string('image100x450')->default('');
            $table->string('image1000x90')->default('');
            $table->timestamp('end_at')->default('0000-00-00 00:00:00');
			$table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('template_id');
            $table->foreign('template_id')->references('id')->on('templates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('poster_themes');
	}

}
