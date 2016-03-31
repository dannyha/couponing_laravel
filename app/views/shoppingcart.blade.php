<h1>Shopping Cart</h1>
<p>User Id: {{ $user[0]->user_id }}</p>
@foreach($user as $item)
    <p>Coupon Id: {{$item->coupon->id}}</p>
    <p>Brand Name: {{$item->coupon->brand_name}}</p>
	<p>Description: {{$item->coupon->offer_description}}</p>
@endforeach