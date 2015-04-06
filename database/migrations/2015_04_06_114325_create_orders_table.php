<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->default(0)->unsigned();
            $table->tinyInteger('shipping_status')->default(0);
            $table->tinyInteger('order_status')->default(0);
            $table->tinyInteger('pay_status')->default(0);
            $table->tinyInteger('shipping_id')->default(0);
            $table->tinyInteger('pay_id')->default(0);
            $table->string('consignee',60)->default('');
            $table->string('address')->default('');
            $table->decimal('goods_amout',10,2)->default(0.00);
            $table->decimal('order_amout',10,2)->default(0.00);
            $table->timestamp('shipping_time')->default('0000-00-00 00:00:00');
            $table->timestamp('confirm_time')->default('0000-00-00 00:00:00');
            $table->timestamp('pay_time')->default('0000-00-00 00:00:00');
            $table->string('tel',60)->default('');
            $table->string('mobile',60)->default('');
            $table->string('email',60)->default('');
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
		Schema::drop('orders');
	}

}
