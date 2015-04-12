<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attributes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('type_id')->default(0)->unsigned();
            $table->string('attr_name',60)->default('');
            $table->tinyInteger('attr_input_type')->default(0);
            $table->tinyInteger('attr_type')->default(0);
            $table->text('attr_value')->nullable();
            $table->tinyInteger('attr_index')->default(0);
            $table->tinyInteger('list_order')->default(0);
			$table->timestamps();

            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('goods_types')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attributes');
	}

}
