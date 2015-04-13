<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirements', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('user_id')->default(0)->unsigned();
            $table->tinyInteger('shipping_status')->default(0);
            $table->tinyInteger('require_status')->default(0);
            $table->tinyInteger('pay_status')->default(0);
            $table->integer('shipping_id')->default(0)->unsigned();
            $table->integer('pay_id')->default(0)->unsigned();
            $table->string('consignee',60)->default('');
            $table->string('address')->default('');
            $table->decimal('goods_amout',10,2)->default(0.00);
            $table->decimal('require_amout',10,2)->default(0.00);
            $table->timestamp('shipping_time')->default('0000-00-00 00:00:00');
            $table->timestamp('confirm_time')->default('0000-00-00 00:00:00');
            $table->timestamp('pay_time')->default('0000-00-00 00:00:00');
            $table->string('tel',60)->default('');
            $table->string('mobile',60)->default('');
            $table->string('email',60)->default('');
            $table->integer('store_id')->default(0)->unsigned();
			$table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('pay_id');
            $table->foreign('pay_id')->references('id')->on('payments');
            $table->index('shipping_id');
            $table->foreign('shipping_id')->references('id')->on('shippings');
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
		Schema::drop('requirements');
	}

}
