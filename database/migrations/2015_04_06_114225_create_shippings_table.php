<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shippings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('shipping_code',20)->default('');
            $table->string('shipping_name',120)->default('');
            $table->string('shipping_desc')->default('');
            $table->string('insure',10)->default('');
            $table->tinyInteger('support_cod')->default(0);
            $table->tinyInteger('enabled')->default(0);
            $table->text('shipping_print')->nullable();
            $table->string('print_bg')->default('');
            $table->text('config_lable')->nullable();
            $table->tinyInteger('print_model')->default(0);
            $table->tinyInteger('shipping_order')->default(0);
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
		Schema::drop('shippings');
	}

}
