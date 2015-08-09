<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//修改字段名image->thumb, body->content
        Schema::table('pages', function(Blueprint $table)
        {
            $table->renameColumn('image', 'thumb');
            $table->renameColumn('body', 'content');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
