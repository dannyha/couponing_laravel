<?php

class CouponStatisticsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{ 

 		$couponStatistics = CouponStatistic::all();
		return View::make('couponstatistics')->with('couponStatistics',$couponStatistics);

		//return CouponStatistic::join('coupons', 'coupon_statistics.coupon_id', '=', 'coupons.id')->get();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Increment the added_to_cart column.
	 *
	 * @param  int  $couponId
	 * @return Response
	 */
	public function addToCart($couponId)
	{
		CouponStatistic::where('coupon_id','=',$couponId)->increment('added_to_cart');

		return CouponStatistic::where('coupon_id','=',$couponId)->get();
	}

	/**
	 * Increment the removed_from_cart column.
	 *
	 * @param  int  $couponId
	 * @return Response
	 */
	public function removeFromCart($couponId)
	{
		CouponStatistic::where('coupon_id','=',$couponId)->increment('removed_from_cart');

		return CouponStatistic::where('coupon_id','=',$couponId)->get();
	}



}
