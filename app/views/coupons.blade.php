@extends('layouts.master')

@section('content')


    <p>TESTING LOCALIZATION: <span style="color:red;">{{ Lang::get('validation.accepted') }}</span></p>

    <div id="cart">
        <h1>CART</h1>
        <a href="javascript:void(0);" id="print">PRINT</a>
    </div>
    <br /><br />
    <div id="sort">
        <a href="javascript:void(0);" id="newDeals" class="selected">Newest</a>
        <a href="javascript:void(0);" id="savings">Savings</a>
        <a href="javascript:void(0);" id="popularDeals">Popular</a>

        <select id="filterBrands">
            <option value="All">All</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option>
            @endforeach
        </select>
    </div>
    <br /><br />
    <div id="coupons">
    @foreach ($offers as $offer)
        <a href="javascript:void(0)" data-coupon="{{ $offer->id }}">
        	{{ $offer->id }} <br />
        	{{ $offer->brand_name }} <br />
        	{{ $offer->category_name }} <br />
       		{{ $offer->offer_description }} <br />
        	{{ $offer->offer_head_line }} <br />
        	{{ $offer->offer_value }} <br />
        	<!--<img src="{{ $offer->image_url }}" /> <br />-->
        	{{ $offer->offer_type_description }} <br />
        </a>
    @endforeach
    </div>

    <script type="template/html" id="template_coupon">
        <a href="javascript:void(0)" data-coupon="">
            <div class="offer_id"></div>
            <div class="offer_brand_name"></div>
            <div class="offer_category_name"></div>
            <div class="offer_description"></div>
            <div class="offer_head_line"></div>
            <div class="offer_value"></div>
            <!--<div class="offer_image_url"></div>-->
            <div class="offer_type_description"></div>
        </a>
    </script>

@stop