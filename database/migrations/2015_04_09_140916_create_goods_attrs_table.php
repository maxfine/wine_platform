<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_attrs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('goods_id')->default(0)->unsigned();
            $table->integer('attr_id')->default(0)->unsigned();
            $table->string('attr_value')->default('');
            $table->decimal('attr_price',10,2)->default(0.00);
			$table->timestamps();

            $table->index('goods_id');
            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('cascade');
            $table->index('attr_id');
            $table->foreign('attr_id')->references('id')->on('attributes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_attrs');
	}

}
