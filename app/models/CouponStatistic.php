<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class CouponStatistic extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'coupon_statistics';

    public $timestamps = true;

	protected $fillable = ['coupon_id', 'printed', 'redeemed', 'added_to_cart', 'remove_from_cart', 'expired_from_cart'];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password', 'remember_token');

	// CouponStatistics__one_to_many_Coupon relationship. Join by coupon_id in the coupon table.
	public function coupon()
	{
		return $this->belongsTo('Coupon');
	}

}
