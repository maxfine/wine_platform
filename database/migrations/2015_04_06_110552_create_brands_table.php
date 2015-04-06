<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brands', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('brand_name',60)->default('');
            $table->string('brand_logo',90)->default('');
            $table->string('brand_url')->default('');
            $table->string('brand_banner',90)->default('');
            $table->text('brand_desc')->nullable();
            $table->tinyInteger('is_show')->default(1);
            $table->tinyInteger('list_order')->default(0);
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
		Schema::drop('brands');
	}

}
