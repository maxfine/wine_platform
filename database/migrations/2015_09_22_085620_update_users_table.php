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
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('nickname', 20)->default('');
            $table->string('realname', 20)->default('');
            $table->string('pid', 20)->default('');
            $table->string('pid_card_thumb1')->default('');
            $table->string('pid_card_thumb2')->default('');
            $table->string('avatar', 80)->default('');
            $table->string('phone', 20)->default('');
            $table->string('address')->default('');
            $table->tinyInteger('is_lock')->default(0);
            $table->enum('user_type', ['Visitor','Customer','Manager'])->default('Visitor');
            $table->string('confirmation_code')->default(''); //注册验证码
            $table->tinyInteger('confirmed')->default(0); //是否通过验证, 0:未通过, 1:通过
            $table->decimal('amount',10,2)->default(0.00);
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
