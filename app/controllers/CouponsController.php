<?php

class CouponsController extends BaseController {


    protected $layout = 'layouts.master';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $data = [
            'offers' => Coupon::where('active','=',true)->get(),
            'brands' => Coupon::distinct()->select('brand_name')->where('active','=',true)->orderBy('brand_name', 'ASC')->get()
        ];

        return View::make('coupons', $data );

	}

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function updateOrCreate()
    {
        
        $client = new \GuzzleHttp\Client();

        $response = $client->get('http://consumeraccessapi.smartsource.com:8080/consumeraccessapi/ConsumerAccessHTTPService/OfferDisplay?req=<offerDisplayRequestValue><linkId>ABAILP6M3U5DK</linkId>%20</offerDisplayRequestValue>');

        $xml = $response->xml();

        // Set active to false for all coupons.
        Coupon::where('active', '=', true)->update(['active' => false]);

        foreach ($xml->OfferDetailList[0]->offer as $offer) {
            
            Coupon::updateOrCreate(
                ['id' => $offer->offerId],
                ['id' => $offer->offerId,
                 'brand_name' => $offer->brandName,
                 'category_name' => $offer->categoryName,
                 'offer_description' => trim($offer->offerDescription),
                 'offer_head_line' => $offer->offerHeadLine,
                 'offer_value' => $offer->offerValue,
                 'image_url' => $offer->imageURL,
                 'offer_type_description' => trim($offer->offerTypeDesc),
                 'active' => 1]);

            CouponStatistic::updateOrCreate(
                ['coupon_id' => $offer->offerId]);

        }

        return Coupon::all();

    }


    /**
     * Return Brand selected and sorted
     *
     * @return Response
     */
    public function getBrandsSorted()
    {

    	$input = Input::all();

    	$brand = (isset($input['brand'])) ? $input['brand'] : 'All';
    	$brand = str_replace("-", "&#45;", $brand);
    	$type = (isset($input['type'])) ? $input['type'] : 'newDeals';
    	$order = (isset($input['order'])) ? $input['order'] : 'ASC';

    	if ($brand === 'All') {
    		if ($type === 'newDeals') {
    			return Coupon::where('active','=',true)->orderBy('created_at', $order)->get();
    		} elseif ($type === 'savings') {
				return Coupon::where('active','=',true)->orderBy('offer_value', $order)->get();
    		} elseif ($type === 'popularDeals') {
    			return CouponStatistic::join('coupons', 'coupon_statistics.coupon_id', '=', 'coupons.id')->where('active','=', 1)->orderBy('added_to_cart',$order)->get();  
    		}
    	} else {
    		if ($type === 'newDeals') {
    			return Coupon::where('brand_name','=',$brand)->where('active','=',true)->orderBy('created_at', $order)->get();
    		} elseif ($type === 'savings') {
    			return Coupon::where('brand_name','=',$brand)->where('active','=',true)->orderBy('offer_value', $order)->get();
    		} elseif ($type === 'popularDeals') {
    			return CouponStatistic::join('coupons', 'coupon_statistics.coupon_id', '=', 'coupons.id')->where('brand_name','=',$brand)->where('active','=', 1)->orderBy('added_to_cart',$order)->get();  
    		}
    	}
    }


    /**
     * Return all brands
     *
     * @return Response
     */
    public function showBrands()
    {

        return Coupon::distinct()->select('brand_name')->where('active','=',true)->orderBy('brand_name', 'ASC')->get();

    }


    /**
     * Return brand selected
     *
     * @return Response
     */
    public function getBrands($brand)
    {

    	$brand = str_replace("-", "&#45;", $brand);
    	if ($brand == 'All') {
    		return Coupon::where('active','=',true)->get();
    	}
		return Coupon::where('brand_name','=',$brand)->where('active','=',true)->get();

    }


    /**
     * Returns all the coupons
     *
     * 
     * @return Response
     */
    public function showCoupons()
    {

        Session::put('coupons', ['test1', 'test2', 'test3']);
        $coupons = Session::get('coupons');
        $coupons = array_merge($coupons, ['test4']);
        Session::put('coupons', $coupons);

        foreach (Session::get('coupons') as $value) {
            //echo $value;
            //echo '<br />';
        }

        //REFERENCE TO XML - http://php.net/manual/en/class.simplexmlelement.php

        $client = new \GuzzleHttp\Client();

        $response = $client->get('http://consumeraccessapi.smartsource.com:8080/consumeraccessapi/ConsumerAccessHTTPService/OfferDisplay?req=<offerDisplayRequestValue><linkId>ABAILP6M3U5DK</linkId>%20</offerDisplayRequestValue>');

        $xml = $response->xml();

        //echo $response->getBody();
        //echo '<br/><br/>=================================================<br/><br/>';
        //echo $xml->code . '<br />';
        //echo $xml->status . '<br />';
        //echo $xml->message . '<br />';

        foreach ($xml->OfferDetailList[0]->offer as $offer) {
            //echo '<br /><br />';
            //echo $offer->offerId . ' <br /> ';
            //echo $offer->brandName . '<br />';
            //echo $offer->categoryName . '<br />';
            //echo $offer->offerDescription . '<br />';
            //echo $offer->offerHeadLine . ' <br /> ';
            //echo $offer->offerValue . '<br />';
        }

        $data = [
            'offers' => $xml->OfferDetailList[0]->offer
        ];

        return View::make('coupons', $data);

    }


}
