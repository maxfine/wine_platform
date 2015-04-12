<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('require_id')->default(0)->unsigned();
            $table->integer('store_id')->default(0)->unsigned();
			$table->timestamps();

            $table->index('require_id');
            $table->foreign('require_id')->references('id')->on('requirements');
            $table->index('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('offers');
	}

}
