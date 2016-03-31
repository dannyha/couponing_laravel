<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function(Blueprint $table)
		{
			$table->string('id');
			$table->primary('id');
			$table->string('brand_name')->nullable();
			$table->string('category_name')->nullable();
			$table->string('offer_description')->nullable();
			$table->string('offer_head_line')->nullable();
			$table->string('offer_value')->nullable();
			$table->string('image_url')->nullable();
			$table->string('offer_type_description')->nullable();
			$table->boolean('active');
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
		Schema::drop('coupons');
	}

}
