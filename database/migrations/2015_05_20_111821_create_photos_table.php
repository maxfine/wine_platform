<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photos', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('goods_id')->default(0)->unsigned();
            $table->string('thumb_url')->default('');
            $table->string('image_url')->default('');
            $table->string('original_url')->default('');
			$table->timestamps();

            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('photos');
	}

}
