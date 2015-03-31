<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToGoods extends Migration {

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //添加字段,商品图片
        Schema::table('goods', function($table){
            $table->string('thumb')->default('');
            $table->foreign('cat_id')->references('id')->on('categories');
            //$table->foreign('brand_id')->references('id')->on('brands');
            //$table->foreign('brand_id')->references('id')->on('brands');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//删除字段
        Schema::table('goods', function(Blueprint $table){
            $table->dropColumn('thumb');
            $table->dropForeign('goods_cat_id_foreign');
        });
	}	

}
