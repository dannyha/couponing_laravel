@extends('layouts.master')

@section('content')
    <br /><br />
    @if(Auth::check())
        <p>Welcome to your profile page {{Auth::user()->first_name}} - {{Auth::user()->last_name}}</p>
    @endif
    

    <table>
    	<tr>
    		<th>id</th>
    		<th>coupon_id</th>
    		<th>printed</th>
    		<th>redeemed</th>
    		<th>added_to_cart</th>
    		<th>removed_from_cart</th>
    		<th>expired_from_cart</th>
    		<th>created_at</th>
    		<th>updated_at</th>
    	</tr>
	    @foreach ($couponStatistics as $stat)
	    <tr>
    		<td> {{ $stat->id}} </td>
    		<td> {{ $stat->coupon_id}} </td>
    		<td> {{ $stat->printed}} </td>
    		<td> {{ $stat->redeemed}} </td>
    		<td> {{ $stat->added_to_cart}} </td>
    		<td> {{ $stat->removed_from_cart}} </td>
    		<td> {{ $stat->expired_from_cart}} </td>
    		<td> {{ $stat->created_at}} </td>
    		<td> {{ $stat->updated_at}} </td>
    	</tr>
	    @endforeach
    </table>
    <br /><br />
@stop