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
            $table->string('goods_sn',60)->default('');
            $table->string('goods_name',120)->default('');
            $table->decimal('market_price',10,2)->default(0.00);
            $table->decimal('shop_price',10,2)->default(0.00);
            $table->string('image',60)->default('');
            $table->integer('type_id')->default(0)->unsigned()->index();
            $table->integer('brand_id')->default(0)->unsigned()->index();
            $table->integer('cat_id')->default(0)->unsigned()->index();
            $table->mediumtext('desc')->nullable();
            $table->text('content')->nullable();
			$table->timestamps();

            //$table->foreign('type_id')->references(id)->on('goods_types');
            //$table->foreign('brand_id')->references(id)->on('brands');
            //$table->foreign('cat_id')->references(id)->on('categories');
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
