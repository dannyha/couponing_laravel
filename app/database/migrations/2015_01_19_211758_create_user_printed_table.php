<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPrintedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_printed', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('coupon_id');
			$table->foreign('coupon_id')->references('id')->on('coupons');
			$table->string('print_id');
			$table->dateTime('printed_on');
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
		Schema::drop('USER_PRINTED');
	}

}
