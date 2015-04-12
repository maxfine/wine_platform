<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_cats', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('goods_id')->default(0)->unsigned();
            $table->integer('cat_id')->default(0)->unsigned();
			$table->timestamps();

            $table->index('goods_id');
            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade')->onUpdate('cascade');
            $table->index('cat_id');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_cats');
	}

}
