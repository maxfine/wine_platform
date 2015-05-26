<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('type_id')->default(0)->unsigned();
            $table->integer('cat_id')->default(0)->unsigned();
            $table->integer('user_id')->default(0)->unsigned();
            $table->string('goods_sn',60)->default('');
            $table->string('goods_name',120)->default('');
            $table->decimal('market_price',10,2)->default(0.00);
            $table->decimal('store_price',10,2)->default(0.00);
            $table->tinyInteger('list_order')->default(0);
            $table->integer('brand_id')->default(0)->unsigned();
            $table->string('image',90)->default('');
            $table->string('brief')->default('');
            $table->text('desc')->nullable();
            $table->tinyInteger('is_show')->default(1);
            $table->tinyInteger('is_hot')->default(0);
            $table->tinyInteger('is_new')->default(0);
			$table->timestamps();

            $table->index('type_id');
            $table->index('cat_id');
            $table->index('brand_id');
            $table->foreign('type_id')->references('id')->on('goods_types');
            $table->foreign('cat_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('brand_id')->references('id')->on('brands');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods');
	}

}
