<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('store_name',60)->default('');
            $table->string('store_logo',80)->default('');
            $table->string('store_url',80)->default('');
            $table->text('store_desc')->nullable();
            $table->string('store_thumb',80)->default('');
            $table->integer('user_id')->default(0)->unsigned();
			$table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stores');
	}

}
