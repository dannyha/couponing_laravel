<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shopping_cart', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('coupon_id');
			$table->foreign('coupon_id')->references('id')->on('coupons');
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
		Schema::drop('SHOPPING_CART');
	}

}
