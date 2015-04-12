<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementGoodsAttrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirement_goods_attrs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('goods_id')->default(0)->unsigned();
            $table->integer('attr_id')->default(0)->unsigned();
            $table->decimal('attr_price',10,2)->default(0.00);
			$table->timestamps();

            $table->index('goods_id');
            $table->foreign('goods_id')->references('id')->on('requirement_goods');
            $table->index('attr_id');
            $table->foreign('attr_id')->references('id')->on('attributes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requirement_goods_attrs');
	}

}
