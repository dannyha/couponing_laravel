<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponStatisticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_statistics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('coupon_id');
			$table->foreign('coupon_id')->references('id')->on('coupons');
			$table->integer('printed')->default(0);
			$table->integer('redeemed')->default(0);
			$table->integer('added_to_cart')->default(0);
			$table->integer('removed_from_cart')->default(0);
			$table->integer('expired_from_cart')->default(0);
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
		Schema::drop('coupon_statistics');
	}

}
