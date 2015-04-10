<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('pay_code',20)->default('');
            $table->string('pay_name',120)->default('');
            $table->string('pay_fee',10)->default('');
            $table->text('pay_desc')->nullable();
            $table->tinyInteger('pay_order')->default(0);
            $table->text('pay_config')->nullable();
            $table->tinyInteger('enabled')->default(0);
            $table->tinyInteger('is_code')->default(0);
            $table->tinyInteger('is_online')->default(0);
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
		Schema::drop('payments');
	}

}
