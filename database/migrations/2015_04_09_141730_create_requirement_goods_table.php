<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('requirement_goods', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('require_id')->default(0)->unsigned();
            $table->integer('goods_id')->default(0)->nullable()->unsigned();
            $table->string('require_sn',60)->default('');
            $table->smallInteger('goods_number')->default(1);
            $table->decimal('goods_price',10,2)->default(0.00);
            $table->text('attr_value')->nullable();
            $table->string('goods_attr_id')->default(''); //商品属性集合
			$table->timestamps();

            $table->index('require_id');
            $table->foreign('require_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->index('goods_id');
            $table->foreign('goods_id')->references('id')->on('goods')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('requirement_goods');
	}

}
