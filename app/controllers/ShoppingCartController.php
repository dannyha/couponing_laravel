<?php

class ShoppingCartController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $shoppingCart = ShoppingCart::all();
    
        return $shoppingCart;
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
     * Add coupon(s).
     *
     * @return Response
     */
    public function addToCart($userId)
    {   

        $coupons = Input::all();

        if(!empty($coupons))
        {
            foreach ($coupons['coupons'] as $coupon) {

                $couponExist = ShoppingCart::where('user_id','=',$userId)->where('coupon_id','=',$coupon['offerId'])->first();

                if(empty($couponExist))
                {
                    ShoppingCart::updateOrCreate(
                    ['user_id' => $userId,
                     'coupon_id' => $coupon['offerId']
                    ],
                    ['user_id' => $userId,
                     'coupon_id' => $coupon['offerId']
                    ]);

                    CouponStatistic::where('coupon_id','=',$coupon['offerId'])->increment('added_to_cart');
                }

            }
        }
      
        return ShoppingCart::where('user_id','=', $userId)->get();
    }

    /**
     * Remove coupon(s).
     *
     * @return Response
     */
    public function removeFromCart($userId)
    {   

        $coupons = Input::all();

        foreach ($coupons['coupons'] as $coupon) {
            $delete = ShoppingCart::where('user_id','=',$userId)->where('coupon_id','=',$coupon['offerId'])->delete();

            if($delete)
            {
                CouponStatistic::where('coupon_id','=',$coupon['offerId'])->increment('removed_from_cart');
            }

        }

        return ShoppingCart::where('user_id','=', $userId)->get();
            
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @return Response
     */
    public function show($userId)
    {
        // Return all coupons in the shopping cart by userid and active.    
        return ShoppingCart::join('coupons', 'shopping_cart.coupon_id', '=', 'coupons.id')->where('user_id','=', $userId)->where('active','=', 1)->get();
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


}
