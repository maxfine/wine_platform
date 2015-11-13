<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
            //$table->integer('group_id')->default(0)->unsigned();
			$table->rememberToken();
			$table->timestamps();

            //修改数据表结构
            $table->string('nickname', 20)->default('');
            $table->string('realname', 20)->default('');
            $table->string('pid', 20)->default('');
            $table->string('pid_card_thumb1')->default('');
            $table->string('avatar', 80)->default('');
            $table->string('phone', 20)->default('');
            $table->string('address')->default('');
            $table->tinyInteger('is_lock')->default(0);
            $table->enum('user_type', ['Visitor','Customer','Manager'])->default('Visitor');
            $table->string('confirmation_code')->default(''); //注册验证码
            $table->tinyInteger('confirmed')->default(0); //是否通过验证, 0:未通过, 1:通过
            $table->decimal('amount',10,2)->default(0.00);
            $table->integer('point')->default(0)->unsigned();
            //$table->index('group_id');
            //$table->foreign('group_id')->references('id')->on('user_groups');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
