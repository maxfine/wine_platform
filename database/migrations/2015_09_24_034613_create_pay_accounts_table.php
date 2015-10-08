<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pay_accounts', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('trade_sn', 60)->default('');
            $table->integer('user_id')->default(0)->unsigned();
            $table->string('username',60)->default('');
            $table->string('contactname',60)->default('');
            $table->string('email',60)->default('');
            $table->string('telephone',20)->default('');
            $table->decimal('discount',10,2)->default(0.00);
            $table->smallInteger('quantity')->default(1);
            $table->timestamp('pay_at')->default('0000-00-00 00:00:00');
            $table->string('usernote')->default('');
            $table->integer('pay_id')->default(0)->unsigned();
            $table->enum('pay_type',['offline','recharge','selfincome','online'])->default('recharge');
            $table->string('payment',90)->default('');
            $table->tinyInteger('type')->default(1);
            $table->string('ip', 15)->default('0.0.0.0');
            $table->enum('status', ['succ','failed','error','progress','timeout','cancel','waitting','unpay'])->default('unpay');
            $table->string('adminnote')->default('');
			$table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('pay_id');
            $table->foreign('pay_id')->references('id')->on('payments');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pay_accounts');
	}

}
