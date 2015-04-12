<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('role_id')->default(0)->unsigned();
            $table->string('user_name',60)->default('');
            $table->char('user_password',64)->default('');
            $table->string('last_ip',15)->default('');
			$table->timestamps();

            $table->index('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admin_users');
	}

}
