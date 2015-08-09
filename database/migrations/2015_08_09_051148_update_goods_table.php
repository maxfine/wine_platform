<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //修改字段名image->thumb, desc->content
        Schema::table('goods', function(Blueprint $table)
        {
            $table->renameColumn('image', 'thumb');
            $table->renameColumn('desc', 'content');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
