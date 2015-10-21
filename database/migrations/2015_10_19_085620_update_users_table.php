<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //添加字段amount
        Schema::table('users', function(Blueprint $table)
        {
            //user_groups外键group_id
            $table->integer('group_id')->nullable()->unsigned()->after('password');
            $table->integer('point')->default(0)->unsigned();

            $table->index('group_id');
            $table->foreign('group_id')->references('id')->on('user_groups');
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
