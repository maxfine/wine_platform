<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_actions', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('action_code',20)->string('');
            $table->string('relevance',20)->string('');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admin_actions');
	}

}
