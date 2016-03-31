<h1>Coupon Statistics!</h1>

@foreach($couponStatistics as $item)
	
	<p>Offer Id: {{ $item->coupon_id }}</p>
	<p>Added to Cart: {{ $item->added_to_cart }}</p>
	<p>Offer Description: {{ $item->coupon->offer_description }} </p>
	<!-- This line displays all coupon details  {{ $item->coupon }} -->
@endforeach
